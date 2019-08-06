/**
 *  Document   : chartjs-data.js
 *  Description: Script for chartjs data.
 *
 **/
'use strict';
 

$(document).ready(function() {
	 var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var color = Chart.helpers.color;
     var barChartData = {
         labels: ["January", "February", "March", "April", "May", "June", "July"],
         datasets: [{
             label: 'Sites',
             backgroundColor: color(window.chartColors.orange).alpha(0.5).rgbString(),
             borderColor: window.chartColors.orange,
             borderWidth: 1,
             data: [
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor()
             ]
			 
         }, {
             label: 'Projects',
             backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
             borderColor: window.chartColors.yellow,
             borderWidth: 1,
             data: [
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor()
             ]
         }, {
             label: 'Supervisors',
             backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
             borderColor: window.chartColors.green,
             borderWidth: 1,
             data: [
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor()
             ]
         }, {
             label: 'Engineers',
             backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
             borderColor: window.chartColors.blue,
             borderWidth: 1,
             data: [
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor()
             ]
         }]

     };

    var chartjs_bar = document.getElementById("chartjs_bar");
    if( chartjs_bar !== null ) {

        var ctx = chartjs_bar.getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        });
    }

});