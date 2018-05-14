$(document).ready( function () {
    $('#joborders').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "pageLength": 25
    });

    $('#purchaseorders').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "pageLength": 25,
        "columnDefs": [
            {
                targets: [ 0, 1, 2 ],
                className: 'mdl-data-table__cell--non-numeric'
            }]
    });
});