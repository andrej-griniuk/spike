<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Invoices Controller
 *
 *
 * @method \App\Model\Entity\Invoice[] paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController
{

    /**
     * Scan method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function scan()
    {
        //$invoice = $this->Invoices->newEntity();
        if ($this->request->is('post')) {
            $vision = new \Vision\Vision(
                Configure::read('Vision.key'),
                [
                    // See a list of all features in the table below
                    // Feature, Limit
                    new \Vision\Feature(\Vision\Feature::TEXT_DETECTION, 100),
                ]
            );

            //$imagePath = $_FILES['file']['tmp_name'];
            $imagePath = $this->request->getData('image.tmp_name');
            $response = $vision->request(
                new \Vision\Image($imagePath)
            );

            $texts = $response->getTextAnnotations();

            //$image = file_get_contents($imagePath);
            $im = imagecreatefromjpeg($imagePath);
            $red = imagecolorallocate($im, 255, 0, 42);
            foreach($texts as $box){

                $points = [];

                $verticles = $box->getBoundingPoly()->getVertices();
                foreach($verticles as $vertex){
                    array_push($points, $vertex->getX(), $vertex->getY());
                }

                imagepolygon($im, $points, count($verticles), $red);

            }

            // give our image a name and store it
            $name = 'invoices' . DS . time().'.jpg';
            $image_name = WWW_ROOT . 'img' . DS . $name;
            imagejpeg($im, $image_name);
            imagedestroy($im);

            $this->Flash->success(__('The invoice has been saved.'));
            $this->set(compact('name'));

            //debug($texts);die;
            /*$invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            */
        }
        $this->set(compact('invoice'));
        $this->set('_serialize', ['invoice']);
    }

}
