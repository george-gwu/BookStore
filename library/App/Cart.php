<?php

class App_Cart implements Serializable  {
    protected $cartData = array();
    private $session;
    
    public function __construct(){ 
        $this->session = new Zend_Session_Namespace('cart');
        
        if(isset($this->session->cart) and !empty($this->session->cart)){
            $this->unserialize($this->session->cart);            
        }
        
        if(!is_array($this->cartData)){
            $this->cartData = array();
            $this->persist();
        }
        
    }
     
   /**
     * Is Cart Empty
     * @return boolean 
     */
    public function isEmpty(){
        return (count($this->cartData) == 0);
    }
    

    /**
     * Returns the contents of the cart in a unindexed array
     * @return type
     */
    public function getItems(){
        $itemList= array_keys($this->cartData);
        
        $items=array();
        
        foreach($itemList as $itemCode){
            $items[] = array('pid'=> $itemCode, 'q' => $this->cartData[$itemCode]['q']);
        }
        
        return $items;
    }    

    /**
     * Add an item to the cart
     * @param type $productID
     */
    public function addItem($productID){
        if(!isset($this->cartData[$productID])){
            $this->cartData[$productID]= array('q'=>1);
        } else {
            $this->cartData[$productID]['q']++;
        }        
        $this->persist();        
    }
    
    /**
     * Delete an item from the cart
     * @param type $productID
     */
    public function deleteItem($productID){
        if(isset($this->cartData[$productID])){            
            unset($this->cartData[$productID]);
            $this->persist();
        }         
    }
    
    
    /**
     * Adjust Item Quantity in Cart
     * @param type $productID
     * @param type $quantity
     */
    public function changeItemQuantity($productID, $quantity){
        if(isset($this->cartData[$productID])){
            if($quantity > 0){
                $this->cartData[$productID]['q'] = $quantity;
            } else {
                unset($this->cartData[$productID]);
            }                                    
            $this->persist();
        }         
    }
    /*
     * Stores changes to the Session
     */
    protected function persist(){
        $this->session->cart = $this->serialize();       
    }
    
    
    public function serialize() {
        return serialize($this->cartData);
    }
    
    public function unserialize($cartData) {
        $this->cartData = unserialize($cartData);
    }

    public function __ToString() {
      return print_r($this->getItems(),1);
    }
}