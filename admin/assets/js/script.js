let bar = document.getElementById("menu-toggle");
let sidebar = document.getElementById("sidebar");
let bodylabel = document.getElementById("body-label");

let toggleBar = () => {
    sidebar.classList.toggle('active');
}

bodylabel.addEventListener('click', event => {
    sidebar.classList.add('active');
});

bar.addEventListener('click', event => {
    toggleBar();
});