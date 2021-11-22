
document.getElementById('searchtype').addEventListener("change", numberType);
function numberType() {
    const type = document.getElementById('searchtype').value;
    if (type === 'prefix') {
        document.getElementById("areacode").style.display = 'block';
    }
}
document.getElementById('checkfornumbers').addEventListener("click", numberSearch);
async function numberSearch(e) {
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    const prefix = document.getElementById('prefix').value;
    const city = document.getElementById('city').value;
    const zip = document.getElementById('zip').value;
    const type = document.getElementById('type').value;
    const token = document.getElementById('token').value;
    let output = '<h3>Available Numbers</h3>';
    let data = {areacode: prefix, city: city, zip: zip, token: token, type: type};
    console.log(data);
    xhr.onload = function() {
        if(this.status === 200) {
            let response = JSON.parse(this.responseText);
            console.log(response);
            document.getElementById('numberdisplay').innerHTML = output;
        }
    }
    xhr.open('POST', 'provision_helper.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);





}


