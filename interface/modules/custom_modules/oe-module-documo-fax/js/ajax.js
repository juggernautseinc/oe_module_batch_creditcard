
document.getElementById('searchtype').addEventListener("change", numberType);
function numberType() {
    const type = document.getElementById('searchtype').value;
    if (type === 'prefix') {
        document.getElementById("areacode").style.display = 'block';
    }
}
document.getElementById('checkfornumbers').addEventListener("click", numberSearch);
function numberSearch(e) {
    e.preventDefault();
    const prefix = document.getElementById('prefix').value;
    const city = document.getElementById('city').value;
    const zip = document.getElementById('zip').value;
    const type = document.getElementById('type').value;
    const token = document.getElementById('token').value;
    let output = '<h3>Available Numbers</h3>';

    fetch('provision_helper.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-type': 'application/json',
            'mode': 'cors',
            'credentials': 'same-origin'
        },
        body:JSON.stringify({type:type, areacode:prefix, city:city, zip:zip})
    })
        .then((res) => res.json())
        .then((data) => {
            if (data != '') {
                console.log(data);
                data = JSON.parse(data);
                data.forEach(function (rows) {
                    output += `
           <div>
                <p>${rows.number}</p>
            </div>
            `;
                });
                document.getElementById('numberdisplay').innerHTML = output;
            } else {
                console.log("Data Empty");
            }
        });//.catch((err) => console.log(err));


}


