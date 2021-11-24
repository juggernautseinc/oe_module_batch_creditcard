
function toggleOrder(id) {

    document.getElementById(id).style.display = 'block';

    document.getElementById('transfer').style.display = 'none';
}

function toggleTransfer(id) {

    document.getElementById(id).style.display = 'block';

    document.getElementById('order').style.display = 'none';
}

function toggleProvisionSubmit() {
    document.getElementById('provisionSubmit').style.display = 'block'
}
