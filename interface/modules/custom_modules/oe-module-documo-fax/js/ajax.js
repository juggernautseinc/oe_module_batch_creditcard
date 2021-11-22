
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
    const state = document.getElementById('state').value;
    const zip = document.getElementById('zip').value;
    const token = document.getElementById('token').value;
    let output = '<h3>Available Numbers</h3>';
    let data = "areacode="+prefix;
    data += "&state="+state;
    data += "&zip="+zip;
    data += "&token="+token;

    xhr.onload = function() {
        if(this.status === 200) {
            let response = JSON.parse(this.responseText);
            response = JSON.stringify(response);
            console.log(response);
            for (let i = 0; i < response.length; i++) {
                output += `
                <div>
                   <p>${response.number}</p>
                </div>
                `;
            }
            document.getElementById('numberdisplay').innerHTML = output;
        }
    }
    xhr.open('POST', 'provision_helper.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);


}


