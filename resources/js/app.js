import * as bootstrap from 'bootstrap';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

window.bootstrap = bootstrap;
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    const shellToggle = document.querySelector('[data-shell-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');

    shellToggle?.addEventListener('click', () => {
        sidebar?.classList.toggle('is-open');
    });

    const chartElement = document.getElementById('accountTrendsChart');
    if (chartElement && window.accountChartData) {
        const data = window.accountChartData;
        new Chart(chartElement, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Credits (Inflow)',
                        data: data.credits,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#10b981',
                    },
                    {
                        label: 'Debits (Outflow)',
                        data: data.debits,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#ef4444',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            font: { family: 'Inter, sans-serif', size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + Number(value).toLocaleString();
                            }
                        },
                        grid: {
                            color: '#e2e8f3'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    const comparisonElement = document.getElementById('creditsDebitsBarChart');
    if (comparisonElement && window.accountChartData) {
        const data = window.accountChartData;
        new Chart(comparisonElement, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Total Inflow',
                        data: data.credits,
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                    },
                    {
                        label: 'Total Outflow',
                        data: data.debits,
                        backgroundColor: '#ef4444',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            font: { family: 'Inter, sans-serif', size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + Number(context.parsed.y).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + Number(value).toLocaleString();
                            }
                        },
                        grid: {
                            color: '#e2e8f3'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
