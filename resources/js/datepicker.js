$(function() {
    $(function(){
        $('.date').datepicker({
            language:'ja',
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('.month').datepicker({
            language:'ja',
            format: 'yyyy/mm',
            autoclose: true,
            minViewMode: 'months'
        });

    });
});
