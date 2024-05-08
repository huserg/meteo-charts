import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import Swal from 'sweetalert2';
import '@fortawesome/fontawesome-free/js/all.min.js'
import 'chartjs-adapter-date-fns';



window.Chart = Chart;

window.Swal = Swal;

window.Alpine = Alpine;
Alpine.start();
