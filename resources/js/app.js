import "./bootstrap";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// Import Chart.js
import Chart from "chart.js/auto";

// Make it globally available
window.Chart = Chart;

// Add ScrollReveal
import ScrollReveal from "scrollreveal";

document.addEventListener("DOMContentLoaded", () => {
    // Initialize Charts
    const userBarGraph = document.getElementById("myUsersChart");
    if (userBarGraph) {

        const data = JSON.parse(userBarGraph.dataset.users);
        const labels = data.map((item) => item.year);
        const counts = data.map((item) => item.count);

        new Chart(userBarGraph, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "# of Users",
                        data: counts,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                            "rgba(255, 205, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                        ],
                        borderColor: [
                            "rgb(255, 99, 132)",
                            "rgb(255, 159, 64)",
                            "rgb(255, 205, 86)",
                            "rgb(75, 192, 192)",
                            "rgb(54, 162, 235)",
                            "rgb(153, 102, 255)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Show whole numbers only
                        },
                    },
                },
            },
        });
    }

    const employmentRateLine = document.getElementById("myPredictedEmploymentRate");
    if (employmentRateLine) {

         const data = JSON.parse(employmentRateLine.dataset.employment);
         const labels = data.map((item) => item.year);
         const rates = data.map((item) =>
             parseFloat(item.average_rate).toFixed(2)
         );

        new Chart(employmentRateLine, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Average Predicted Employment Rate (%)",
                        data: rates,
                        fill: false,
                        borderColor: "rgb(213,11,139)",
                        tension: 0.3,
                        pointBackgroundColor: "white",
                        pointBorderColor: "rgb(67, 0, 87)",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, // Assuming percentage is 0-100
                        ticks: {
                            callback: function (value) {
                                return value + "%";
                            },
                        },
                    },
                },
            },
        });
    }

    // ScrollReveal animations
    ScrollReveal().reveal(".reveal", {
        duration: 1000,
        distance: "50px",
        origin: "bottom",
        opacity: 0,
        easing: "ease-in-out",
        reset: true,
        mobile: true,
        scale: 1,
        cleanup: true,
    });

    ScrollReveal().reveal(".reveal-left", {
        duration: 1000,
        distance: "100px",
        origin: "left",
        opacity: 0,
        reset: true,
        scale: 1,
        cleanup: true,
    });

    ScrollReveal().reveal(".reveal-right", {
        duration: 1000,
        distance: "100px",
        origin: "right",
        opacity: 0,
        reset: true,
        scale: 1,
        cleanup: true,
    });

    ScrollReveal().reveal(".reveal-stagger", {
        duration: 800,
        distance: "30px",
        origin: "bottom",
        interval: 100,
        reset: true,
        scale: 1,
        cleanup: true,
    });
});
