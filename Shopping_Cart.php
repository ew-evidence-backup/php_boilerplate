<?php
/**
 * Author: Evin Weissenberg
 * Email: evin.weissenberg.developer@gmail.com
 * Date: 9/18/11
 * Time: 9:53 PM
 */
/*
SHOPPING BASKET CLASS

USAGE:
------

$cart = new ShoppingBasket; Initialize class
$cart->SaveCookie(TRUE); Set option to save items ina cookie or not. Cookie valid for 1 day.
$cart->AddToBasket('ITEM_ID', QTY); Add an item to the basket
$cart->RemoveFromBasket('ITEM_ID', QTY); Remove item form basket
$cart->DeleteFromBasket('ITEM_ID'); Removes all of item selected
$cart->EmptyBasket('ITEM_ID' QTY); Clear the basket
$cart->GetBasketQty(); Get qty of items in the basket
$cart->GetBasket(); Returns basket items as an array ITEM_ID => QTY

*/

/**
 * ShoppingBasket
 *
 * A simple shopping basket class used to add and delete items from a session based shopping cart
 * @package ShoppingBasket
 * @author Dave Nicholson <dave@davenicholson.co.uk>
 * @link http://davenicholson.co.uk
 * @copyright 2008
 * @version 0.1
 * @access public
 */
class ShoppingCart {

    public $cookieName = 'ewBasket';
    public $cookieExpire = 86400; // One day
    public $saveCookie = TRUE;

    function __construct() {

        session_start();

        if (!isset($_SESSION['cart']) && (isset($_COOKIE[$this->cookieName]))) {
            $_SESSION['cart'] = unserialize(base64_decode($_COOKIE[$this->cookieName]));
        }

    }

    function AddToBasket($id, $qty = 1) {

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $_SESSION['cart'][$id] + $qty;
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
        $this->SetCookie();
        return true;
    }

    function RemoveFromBasket($id, $qty = 1) {

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $_SESSION['cart'][$id] - $qty;
        }

        if ($_SESSION['cart'][$id] <= 0) {
            $this->DeleteFromBasket($id);
        }

        $this->SetCookie();
        return true;
        exit();
    }

    function DeleteFromBasket($id) {
        unset($_SESSION['cart'][$id]);
        $this->SetCookie();
        return true;
        exit();
    }


    function GetBasket() {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $k => $v) {
                $itemArray[$k] = $v;
            }
            return $itemArray;
            exit();
        } else {
            return false;
        }
    }

    function UpdateBasket($id, $qty) {

        $qty = ($qty == '') ? 0 : $qty;

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $qty;

            if ($_SESSION['cart'][$id] <= 0) {
                $this->DeleteItem($id);
                return true;
                exit();
            }
            $this->SetCookie();
            return true;
            exit();

        } else {
            return false;
        }

    }

    function GetBasketQty() {
        if (isset($_SESSION['cart'])) {
            $qty = 0;
            foreach ($_SESSION['cart'] as $item) {
                $qty = $qty + $item;
            }
            return $qty;
        } else {
            return 0;
        }
    }

    function EmptyBasket() {
        unset($_SESSION['cart']);
        $this->SetCookie();
        return true;
    }

    function SetCookie() {

        if ($this->saveCookie) {
            $string = base64_encode(serialize($_SESSION['cart']));
            setcookie($this->cookieName, $string, time() + $this->cookieExpire, '/');
            return true;
        }

        return false;
    }

  /**
   * ShoppingBasket::SaveCookie()
   *
   * Sets save cookie option
   * @param bool $bool
   * @return bool
   */
    function SaveCookie($bool = TRUE) {
        $this->saveCookie = $bool;
        return true;
    }
}

