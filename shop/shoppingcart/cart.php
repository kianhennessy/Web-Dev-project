<?php

if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {


    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // prep the SQL statement
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from DB and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if ($product && $quantity > 0) {

        // Product exists in DB
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart, updates quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // no products in cart will add first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // prevents form resubmission
    header('location: index.php?page=cart');
    exit;
}


if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {

    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page

if (isset($_POST['update']) && isset($_SESSION['cart'])) {

    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }

    header('location: index.php?page=cart');
    exit;
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

// check sessions for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// if products in cart
if ($products_in_cart) {

    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');


    $stmt->execute(array_keys($products_in_cart));

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
            <tr>
                <td colspan="2">Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="img">
                            <a href="index.php?page=product&id=<?=$product['id']?>">
                                <img src="../shopimgs/<?=$product['img']?>" width="75" height="42" alt="<?=$product['name']?>">
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                            <br>
                            <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                        </td>
                        <td class="price">&dollar;<?=$product['price']?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                        </td>
                        <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>
