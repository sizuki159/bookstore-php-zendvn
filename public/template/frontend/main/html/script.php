<script>
    function openSearch() {
        document.getElementById("search-overlay").style.display = "block";
        document.getElementById("search-input").focus();
    }

    function closeSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }

    var moduleName      = <?php echo $this->arrParam['module'] ?>
    var controllerName  = <?php echo $this->arrParam['controller'] ?>
    var actionName      = <?php echo $this->arrParam['action'] ?>

</script>