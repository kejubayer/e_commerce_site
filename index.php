<?php $title = 'Home'; ?>
<?php require_once 'partials/_header.php'; ?>
<?php
$query = 'SELECT id, name, slug, image, price FROM products';
$stmt = $connection->query($query);
$stmt->execute();

$products = $stmt->fetchAll();
?>

<main role="main">

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Welcome to our store!</h1>
            <p class="lead text-muted">Browse our products and buy easily.</p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?php echo $product['image']; ?>" alt="">
                        <div class="card-body">
                            <p class="card-text"><?php echo $product['name']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        Add to Cart
                                    </button>
                                </div>
                                <small class="text-muted">BDT <?php echo $product['price']; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>

</main>

<?php require_once 'partials/_footer.php'; ?>
