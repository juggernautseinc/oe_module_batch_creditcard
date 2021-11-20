
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
    //alert('Do number search via ajax ' + prefix);
    let output = '<h3>Available Numbers</h3>';
    fetch('provisino_helper.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-type': 'application/json'
        },
        body:JSON.stringify({areacode:prefix})
    })
        .then((res) => res.json())
        .then((data) => {
            //output += data;
            console.log(data);

        });
    document.getElementById('numberdisplay').innerHTML = output;

}


