
const countdown=()=>{

    const now = new Date().getTime();
    const countDate = new Date("Julie 6, 2022 00:00:00").getTime();
    const gap = countDate - now;

    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const day = hour * 24;

    const d = Math.floor(gap / (day));
    const h = Math.floor((gap % (day)) / (hour));
    const m = Math.floor((gap % (hour)) / (minute));
    const s = Math.floor((gap % (minute)) / (second));

    document.querySelector('.day').innerText = d;
    document.querySelector('.hour').innerText = h;
    document.querySelector('.minute').innerText = m;
    document.querySelector('.second').innerText = s;

}


    setInterval(countdown,1000);