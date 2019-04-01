<?php
$title = 'Cart';
session_start();
require_once 'database/connection.php';
if (isset($_POST['clear'])){
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}
if (isset($_POST['delete'])){
    $key = (string)$_POST['id'];
    unset($_SESSION['cart'][$key]);
    header('Location: cart.php');
    exit();
}
if (isset($_POST['decrease'])){
    $key = (string)$_POST['id'];
    if (array_key_exists($key,$_SESSION['cart'])){
        $query = 'SELECT price FROM products WHERE id=:id';
        $stmt = $connection ->prepare($query);
        $stmt->bindParam(':id',$key, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();
        if ($_SESSION['cart'][$key]['quantity'] > 1){
            $_SESSION['cart'][$key]['quantity']--;
            $_SESSION['cart'][$key]['total_price'] -= $product['price'];
            $_SESSION['cart'][$key]['total_price'] = (float)$_SESSION['cart'][$key]['total_price'];
        }
    }
    header('Location: cart.php');
    exit();

}

$cart =$_SESSION['cart'] ?? [];

if (isset($_POST['add'])){
    $id = (int)$_POST['id'];
    try{
        $query = 'SELECT name, price FROM products WHERE id=:id';
        $stmt = $connection ->prepare($query);
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();
        $key = (string) $id;

        if (array_key_exists($key, $cart)){
            $cart[$key]['quantity']++;
            $cart[$key]['total_price'] += $cart[$key]['price'];
            $cart[$key]['total_price'] = (float)$cart[$key]['total_price'];
        }else{
            $cart [$key]=[
                'name' => $product['name'],
                'price' =>(float) $product['price'],
                'quantity' =>(int) 1,
                'total_price' => (float)$product['price']
            ];
        }

        $_SESSION['cart']=$cart;
        header('Location: cart.php');
        exit();

    }catch (Exception $e){
        die($e->getMessage());
    }
}

$total_price = !empty($cart) ? array_sum(array_column($cart,'total_price')) : 0;

require_once 'partials/_header.php';

?>

<main role="main">
    <div class="container">
        <br>
        <p class="text-center">Cart</p>
        <hr>

        <div class="row">
            <?php if (empty($cart)): ?>
            <div class="alert alert-warning">
                Please add some products first .
            </div>
            <?php else: ?>
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <td>Sl.</td>
                    <td>Product Title</td>
                    <td>Quantity</td>
                    <td>Unit Price</td>
                    <td>Total Price</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($cart as $key => $product): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td>BDT <?php echo number_format($product['price'],2); ?></td>
                    <td>BDT <?php echo number_format($product['total_price'], 2); ?></td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $key; ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger" >
                                [X]
                            </button>
                        </form>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $key; ?>">
                            <button type="submit" name="decrease" class="btn btn-sm btn-danger" >
                                [-]
                            </button>
                        </form>
                    </td>
                </tr>
                <? endforeach; ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Price</td>
                    <td>BDT <?php echo number_format($total_price , 2) ; ?></td>
                    <td>
                        <a href="checkout.php" class="btn btn-success">Checkout</a>
                        <form action="cart.php" method="post">
                            <button type="submit" name="clear" class="btn btn-sm btn-danger" >
                                [X]
                            </button>
                        </form>
                    </td>
                </tr>

                </tbody>
            </table>
            <?php endif;?>
        </div>

    </div>
</main>

<?php require_once 'partials/_footer.php'; ?>
