import './bootstrap';
import 'flowbite';
import Chart from 'chart.js/auto';

import DataTable from "simple-datatables";
import "simple-datatables/dist/style.css"; // If you need the styles

document.addEventListener("DOMContentLoaded", function () {
  const dataTable = new DataTable("#default-table");
});
