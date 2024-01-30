<!DOCTYPE html>
<html lang="en">

<head>
    <script>
    <?php
        $javascript = '
        var searchParams    = \''.json_encode($this->arrParam).'\';
        const ROOT_URL = \''.ROOT_URL.'\';
        ';
        echo $javascript;
    ?>
    </script>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <?php echo $this->_title; ?>

    <?php require_once 'html/head.php'; ?>

    <?php echo $this->_cssFiles; ?>
</head>

<body>

    <?php require_once 'html/header/header.php'; ?>

    <?php
        require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
    ?>

    <?php require_once 'html/footer.php'; ?>

    <?php require_once 'html/tap_top.php'; ?>

    <?php echo $this->_jsFiles; ?>

    <?php require_once 'html/script.php'; ?>

</body>

</html>