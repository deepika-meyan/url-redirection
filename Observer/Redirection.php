<?php 
namespace Meticulosity\UrlRedirection\Observer;
 
use Magento\Framework\Event\ObserverInterface;
 
class Redirection implements ObserverInterface
{

   public $urlInterface;
   public $request;
   public $redirect;
   public $productRepository;


   public function __construct(
      \Magento\Framework\UrlInterface $urlInterface,
      \Magento\Framework\App\RequestInterface $request,
      \Magento\Catalog\Model\ProductRepository $productRepository,
     \Magento\Framework\App\Response\RedirectInterface $redirect

   ) {
      $this->urlInterface = $urlInterface;
      $this->request = $request;
      $this->_productRepository = $productRepository;
      $this->redirect = $redirect;
   }
   public function execute(\Magento\Framework\Event\Observer $observer)
   {

      $this->urlInterface->getCurrentUrl();
      $controller = $observer->getControllerAction();
      $url = $this->urlInterface->getCurrentUrl();

      $substring = "catalog/product/view/id/";

      if (strpos($url, $substring) !== false) {

         $productId = $this->request->getParam('id');
         $product = $this->_productRepository->getById($productId);
         $key = $product->getUrlModel()->getUrl($product);
         $this->redirect->redirect($controller->getResponse(), $key);

         return $this;

      }


   }
       

      


   
}