// Function to handle clock display
const initializeClock = () => {
    const hour = document.getElementById('clock-hour'),
        minutes = document.getElementById('clock-minutes'),
        seconds = document.getElementById('clock-seconds');

    // Use requestAnimationFrame for smoother animations
    const clock = () => {
        let date = new Date();
        let hh = date.getHours() * 30,
            mm = date.getMinutes() * 6,
            ss = date.getSeconds() * 6;

        hour.style.transform = `rotateZ(${hh + mm / 12}deg)`;
        minutes.style.transform = `rotateZ(${mm}deg)`;
        seconds.style.transform = `rotateZ(${ss}deg)`;

        // Request the next frame
        requestAnimationFrame(clock);
    };
    requestAnimationFrame(clock);

    const textHour = document.getElementById('text-hour'),
        textMinutes = document.getElementById('text-minutes'),
        textAmPm = document.getElementById('text-ampm'),
        dateDay = document.getElementById('date-day'),
        dateMonth = document.getElementById('date-month'),
        dateYear = document.getElementById('date-year');

    const updateText = (element, newValue) => {
        if (element.innerHTML !== newValue) {
            element.innerHTML = newValue;
        }
    };

    const clockText = () => {
        let date = new Date();
        let hh = date.getHours(),
            ampm,
            mm = date.getMinutes(),
            day = date.getDate(),
            month = date.getMonth(),
            year = date.getFullYear();

        // AM/PM logic
        if (hh >= 12) {
            hh = hh - 12;
            ampm = 'PM';
        } else {
            ampm = 'AM';
        }

        if (hh == 0) { hh = 12; }
        if (hh < 10) { hh = `0${hh}`; }

        // Nama bulan dalam bahasa Indonesia
        let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        updateText(textHour, `${hh}:`);
        if (mm < 10) { mm = `0${mm}`; }
        updateText(textMinutes, mm);
        updateText(textAmPm, ampm);
        updateText(dateDay, day);
        updateText(dateMonth, `${months[month]},`);
        updateText(dateYear, year);
    };

    setInterval(clockText, 1000); // Update every second
};

// Function to handle theme toggle
const initializeTheme = () => {
    const themeButton = document.getElementById('theme-button');
    const darkTheme = 'dark';
    const iconTheme = 'bxs-sun';

    const selectedTheme = localStorage.getItem('selected-theme');
    const selectedIcon = localStorage.getItem('selected-icon');

    const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light';
    const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'bxs-moon' : 'bxs-sun';

    if (selectedTheme) {
        document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme);
        themeButton.classList[selectedIcon === 'bxs-moon' ? 'add' : 'remove'](iconTheme);
    }

    themeButton.addEventListener('click', () => {
        document.body.classList.toggle(darkTheme);
        themeButton.classList.toggle(iconTheme);
        localStorage.setItem('selected-theme', getCurrentTheme());
        localStorage.setItem('selected-icon', getCurrentIcon());
    });
};

// Run functions based on the current page
document.addEventListener('DOMContentLoaded', () => {
    const allowedPages = ['/', '/home'];
    const currentPage = window.location.pathname;

    if (allowedPages.includes(currentPage)) {
        initializeClock();
    }

    initializeTheme();
});
