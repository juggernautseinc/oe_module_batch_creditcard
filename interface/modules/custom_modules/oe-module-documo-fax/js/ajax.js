
document.getElementById('searchtype').addEventListener("change", numberType);
function numberType() {
    const type = document.getElementById('searchtype').value;
    if (type === 'prefix') {
        document.getElementById("areacode").style.display = 'block';
    }
}
document.getElementById('checkfornumbers').addEventListener("click", numberSearch);
function numberSearch() {
    const prefix = document.getElementById('prefix').value;
    const city = document.getElementById('city').value;
    const zip = document.getElementById('zip').value;
    const type = document.getElementById('type').value;
    let output = '<h3>Available Numbers</h3>';
    fetch('provision_helper.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-type': 'application/json'
        },
        body:JSON.stringify({type:type, areacode:prefix, city:city, zip:zip})
    })
        .then((res) => res.json())
        .then((data) => {
            //output += data;
            console.log(data);

        });
    document.getElementById('numberdisplay').innerHTML = output;

}


