import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import mask from '@alpinejs/mask';
// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// FullCalendar
import { Calendar } from '@fullcalendar/core';

import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect/index';
import 'flatpickr/dist/plugins/monthSelect/style.css';



window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;
window.monthSelectPlugin = monthSelectPlugin;

Alpine.plugin(mask);

Alpine.magic('maskMoney', () => {
    return (input) => {
        let value = input.value.replace(/\D/g, '');

        if (!value) {
            input.value = '';
            return null;
        }

        let number = Number(value) / 100;

        input.value = number.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        return number;
    };
});

Alpine.magic('cpfCnpjMask', () => {
    return (value) => {
        // conta apenas dígitos
        const digits = value.replace(/\D/g, '');

        // CPF → 11 dígitos
        if (digits.length <= 11) {
            return '999.999.999-99';
        }

        // CNPJ → 14 dígitos
        return '99.999.999/9999-99';
    };
});

Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(module => module.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(module => module.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(module => module.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(module => module.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(module => module.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(module => module.initChartThirteen());
    }

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }
});
