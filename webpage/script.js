function changeItem() {
    document.getElementById("fireFly").style.color = '#00F4C8';
    document.getElementById("trinityLogo").style.backgroundImage = "url(images/iota-miota-logo-blue.png)";
}// функция, которая сработает при наведении.
//она означает - выбрать элемент к Id у которого надо что-то изменить.
// когда в скобки где написано one-two добавите Id своего элемента
function rechangeItem() {
    document.getElementById("fireFly").style.color = '#FFFFFF';
    document.getElementById("trinityLogo").style.backgroundImage = "url(images/iota-miota-logo.png)";
}// тут всё также. но наобарот. протсес происходящий про отводе курсора.

function show(state) {
    document.getElementById('popUp').style.display = state;
    document.getElementById('gray').style.display = state;
}