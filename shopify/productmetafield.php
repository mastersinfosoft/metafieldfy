<?php
include '../config.php';
require '../vendor/autoload.php';

$unstall_data = get_unstall_webhook($shopdata[0]['store_name'], $shopdata[0]['access_token']);
$unstall_data_array = (array) json_decode($unstall_data);
//if (!is_array($unstall_data_array)) {
//    $delete_query = "delete from tbl_usersettings where store_name = '" . $shop . "';";
//    $delete_store = $db->query($delete_query);
//    header("Location: https://metafieldfy.herokuapp.com/shopify_app.php");
//}
$productjson = get_products($shopdata[0]['store_name'], $shopdata[0]['access_token'], $_GET['id'], "id,images,title");
$product = (array) json_decode($productjson);
if (isset($_POST['submit']) && $_POST['submit'] == 'Add') {

    $data = array(
        'namespace' => isset($_POST['namespace']) ? $_POST['namespace'] : '',
        'key' => isset($_POST['key']) ? $_POST['key'] : '',
        'value_type' => isset($_POST['value_type']) ? ($_POST['value_type'] == 'html') ? 'string' : $_POST['value_type'] : '',
        'value' => isset($_POST['fvalue']) ? $_POST['fvalue'] : '',
        'description' => isset($_POST['value_type']) ? $_POST['value_type'] : ''
    );
    $datanew = array();
    $dataexisting = array();
    $namespace = $_POST['namespace'];
    foreach ($_POST['key'] as $key => $value) {
        if ($key != 'new') {
            $dataexisting[$key]['metafield']['namespace'] = $namespace;
            $dataexisting[$key]['metafield']['key'] = $_POST['key'][$key];
            $dataexisting[$key]['metafield']['value_type'] = isset($_POST['value_type'][$key]) ? ($_POST['value_type'][$key] == 'html') ? 'string' : $_POST['value_type'][$key] : '';
            $dataexisting[$key]['metafield']['value'] = $_POST['fvalue'][$key];
            $dataexisting[$key]['metafield']['description'] = $_POST['value_type'][$key];
        } else {
            $datanew['new']['metafield']['namespace'] = $namespace;
            $datanew['new']['metafield']['key'] = $_POST['key'][$key];
            $datanew['new']['metafield']['value_type'] = isset($_POST['value_type'][$key]) ? ($_POST['value_type'][$key] == 'html') ? 'string' : $_POST['value_type'][$key] : '';
            $datanew['new']['metafield']['value'] = $_POST['fvalue'][$key];
            $datanew['new']['metafield']['description'] = $_POST['value_type'][$key];
        }
    }
    //$responce = add_metafield($shopdata[0]['store_name'], $shopdata[0]['access_token'], 'products', $_GET['id'], $data);
    if (count($dataexisting) > 0) {
        foreach ($dataexisting as $mid => $data) {
            update_metafield($shopdata[0]['store_name'], $shopdata[0]['access_token'], 'products', $_GET['id'], $mid, $data);
        }
    }
     if (count($datanew) > 0) {
        foreach ($datanew as $mid => $data) {
            add_metafield($shopdata[0]['store_name'], $shopdata[0]['access_token'], 'products', $_GET['id'], $data['metafield']);
        }
    }
    echo '<pre>';
    print_r($_POST);
    print_r($dataexisting);
    print_r($datanew);
    echo '</pre>';
}
$metafields_json = get_metafield($shopdata[0]['store_name'], $shopdata[0]['access_token'], 'products', $_GET['id']);
$metafields = json_decode($metafields_json);
$count_metafield = count($metafields->metafields);
$ourmetafield = array();
for ($i = 0; $i < $count_metafield; $i++) {
    if ($metafields->metafields[$i]->namespace == 'masterfields') {
        $ourmetafield[] = $metafields->metafields[$i];
    }
}
echo '<pre>';
print_r($ourmetafield);
echo '</pre>';
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="jquery-te-1.4.0.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="jquery-te-1.4.0.min.js" charset="utf-8"></script>
        <script type="text/javascript">
            $('document').ready(function () {
                //$('.jqte-test').jqte();
                $("[id^=value_type_]").each(function () {
                    ids = this.id;
                    ids = ids.split('_');
                    $('#fvalue_' + ids[2]).jqte();
                });
                $("[id^=value_type_]").change(function ()
                {
                    ids = this.id;
                    ids = ids.split('_');

                    if ($(this).val() == 'html') {
                        jqteStatus = true;
                    } else {
                        jqteStatus = false;
                    }
                    //jqteStatus = jqteStatus ? false : true;

                    $('#fvalue_' + ids[2]).jqte({"status": jqteStatus})
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <h2>Metafields for <?php echo $product['product']->title ?></h2> 
            <a href="addmetafields.php" class="btn btn-primary" >Back</a>
            <div class="row">

                <div class="col-sm-12 col-md-12">
                    <form method="post" id="addmetafield" name="addmetafield">
                        <input type="hidden" value="masterfields" name="namespace">
                        <?php
                        if (count($ourmetafield) > 0) {
                            ?>
                            <fieldset>
                                <legend>Update Existing Fields</legend>
                                <?php
                                foreach ($ourmetafield as $value) {
                                    ?>
                                    <div class="form-group">
                                        <label for="email">Key:</label>
                                        <input type="text" class="form-control" value="<?php echo $value->key ?>" name="key[<?php echo $value->id ?>]" id="key_<?php echo $value->id ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Type:</label>
                                        <select type="text" class="form-control value_type" name="value_type[<?php echo $value->id ?>]" id="value_type_<?php echo $value->id ?>">
                                            <option value="html">Html</option>
                                            <option value="string">text</option>
                                            <option value="integer">Numbers</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Value:</label>
                                        <textarea class="form-control jqte-test" name="fvalue[<?php echo $value->id ?>]" id="fvalue_<?php echo $value->id ?>"><?php echo $value->value ?></textarea>
                                    </div>
                                    <?php
                                }
                                ?>
                            </fieldset>
                            <?php
                        }
                        ?>
                        <fieldset>
                            <legend>New Field</legend>
                            <div class="form-group">
                                <label for="email">Key:</label>
                                <input type="text" class="form-control" name="key[new]" id="key_new">
                            </div>
                            <div class="form-group">
                                <label for="email">Type:</label>
                                <select type="text" class="form-control" name="value_type[new]" id="value_type_new">
                                    <option value="html">Html</option>
                                    <option value="string">text</option>
                                    <option value="integer">Numbers</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Value:</label>
                                <textarea class="form-control jqte-test" name="fvalue[new]" id="fvalue_new"></textarea>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Add" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </body>
</html>