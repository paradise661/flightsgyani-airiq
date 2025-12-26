require('./bootstrap');
// require('popper.js/dist/popper');
// require('admin-lte');
import Swal from 'sweetalert2';

window.swal = Swal;

require('preline/dist/preline.js')
require('./typeahead');
require('./custom');
require('./flightsearch');
require('./responsive-flightsearch')
require('./datepicker')

