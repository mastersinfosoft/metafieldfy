<?php
require '../config.php';
require '../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <h2>Product Metafields for Shopify</h2>
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <?php include 'sidebar.php'; ?>
                </div>
                <div class="col-sm-9 col-md-9">
                    <?php
                    $products_json = get_all_products($shopdata[0]['store_name'], $shopdata[0]['access_token'], "id,images,title");
                    echo '<pre>weqwe';
                    print_r((array) json_decode($products_json));
                   
                    $products = (array) json_decode($products_json);
                    print_r($products['products']);
                    echo '</pre>';
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totle_prodcts = count($products);
                            for ($i = 0; $i < $totle_prodcts; $i++) {
                                ?>
                            <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $products[$i]->title ?></td>
                                <td><img src="<?php echo $products[$i]->images[0]->src ?>" alt="" /></td>
                                <td><a href="productmetafield.php?id=<?php echo $products[$i]->id ?>" class="btn btn-primery" >Add Metafield</a></td>
                            </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>