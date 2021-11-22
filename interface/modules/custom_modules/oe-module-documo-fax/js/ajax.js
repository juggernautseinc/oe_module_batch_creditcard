
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
    const prefix = document.getElementById('prefix').value;
    const city = document.getElementById('city').value;
    const zip = document.getElementById('zip').value;
    const type = document.getElementById('type').value;
    const token = document.getElementById('token').value;
    let output = '<h3>Available Numbers</h3>';

    await fetch('provision_helper.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'mode': 'cors',
            'credentials': 'same-origin'
        },
        body: JSON.stringify({areacode: prefix, city: city, zip: zip})
    })
        .then((res) => res.json())
        .then((data) => {
                //data = JSON.parse(data);
                console.log(data);
                //data.forEach(function (rows) {
                //  output += `
                //<div>
                //   <p>${rows.number}</p>
                //</div>
                //`;
                //});
                document.getElementById('numberdisplay').innerHTML = output;

        }).catch((err) => console.log(err));


}


