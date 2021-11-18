/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

function toggleOrder(id) {

    document.getElementById(id).style.display = 'block';

    document.getElementById('transfer').style.display = 'none';
}

function toggleTransfer(id) {

    document.getElementById(id).style.display = 'block';

    document.getElementById('order').style.display = 'none';
}
