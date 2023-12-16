// SIDEBAR
const menuItems = document.querySelectorAll('.menu-item');

//CHAT USERS
const chatUsers = document.querySelectorAll('.useractive');

// MESSAGES
const messageNotification = document.querySelector('#messages-notifications');
const messages = document.querySelector('.messages');
const message = messages.querySelectorAll('.message');
const messageSearch = document.querySelector('#message-search');
const messageSearchGeneral = document.querySelector('#message-search-general');

// THEME
const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span');
var root = document.querySelector(':root');
const colorPalette = document.querySelectorAll('.choose-color span');
const Bg1 = document.querySelector('.bg-1');
const Bg2 = document.querySelector('.bg-2');
const Bg3 = document.querySelector('.bg-3');


// SIDEBAR
// Удаляем класс active из всех классов меню
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active');
    })
}
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active');
        if(item.id != 'notifications') {
            document.querySelector('.notifications-popup').
            style.display = 'none';
        }
        else {
            document.querySelector('.notifications-popup').
            style.display = 'block';
            document.querySelector('#notifications .notification-count').style.display = 'none';
        }
    })
})


// CHAT USERS
// Удаляем класс active из всех классов меню
const changeUserActiveItem = () => {
    chatUsers.forEach(item => {
        item.classList.remove('active');
    })
}
chatUsers.forEach(item => {
    item.addEventListener('click', () => {
        changeUserActiveItem();
        item.classList.add('active');
    })
})




// MESSAGES
// Поиски чатов
const searchMessage = () => {
    const val = messageSearch.value.toLowerCase();
    message.forEach(user => {
        let name = user.querySelector('h5').textContent.toLowerCase();
        let chat = user.querySelector('p').textContent.toLowerCase();
        if (name.indexOf(val) != -1 || chat.indexOf(val) != -1) {
            user.style.display = 'flex';
        }
        else {
            user.style.display = "none";
        }
    })
}

const searchUser = () => {
    const val = messageSearchGeneral.value.toLowerCase();
    chatUsers.forEach(user => {
        let name = user.querySelector('p').textContent.toLowerCase();
        if (name.indexOf(val) != -1) {
            user.style.display = 'flex';
        }
        else {
            user.style.display = "none";
        }
    })
}

// Поиск чата
messageSearch.addEventListener('keyup', searchMessage);
messageSearchGeneral.addEventListener('keyup', searchUser);

// Выделение сообщений и удаление числа сообщений, когда кликают Messages
messageNotification.addEventListener('click', () => {
    messages.style.boxShadow = '0 0 1rem var(--color-primary)';
    messageNotification.querySelector('.notification-count').style.display = 'none';
    setTimeout(() => {
        messages.style.boxShadow = 'none';
    }, 2000)
})

// THEME/DISPLAY CUSTOMIZATION

// Фунция открытия модального окна
const openThemeModal = () => {
    themeModal.style.display = 'grid';
}

// Фунция закрытия модального окна
const closeThemeModal = (e) => {
    if (e.target.classList.contains('customize-theme')) {
        themeModal.style.display = 'none';
    }
}


// Открытие модального окна
theme.addEventListener('click', openThemeModal);

// Закрытие модального окна
themeModal.addEventListener('click', closeThemeModal);

// FONTS

// Удаление класса актив из панели выбора шрифтов
const removeSizeSelector = () => {
    fontSizes.forEach(size => {
        size.classList.remove('active');
    })
}

fontSizes.forEach(size => {
    size.addEventListener('click', () => {
        removeSizeSelector();
        let fontSize;
        size.classList.toggle('active');
        if (size.classList.contains('font-size-1')) {
            fontSize = '10px';
            root.style.setProperty('----sticky-top-left', '5.4rem');
            root.style.setProperty('----sticky-top-right', '5.4rem');
        }
        else if (size.classList.contains('font-size-2')) {
            fontSize = '13px';
            root.style.setProperty('----sticky-top-left', '5.4rem');
            root.style.setProperty('----sticky-top-right', '-7rem');
        }
        else if (size.classList.contains('font-size-3')) {
            fontSize = '16px';
            root.style.setProperty('----sticky-top-left', '-2rem');
            root.style.setProperty('----sticky-top-right', '-17rem');
        }
        else if (size.classList.contains('font-size-4')) {
            fontSize = '19px';
            root.style.setProperty('----sticky-top-left', '-5rem');
            root.style.setProperty('----sticky-top-right', '-25rem');
        }
        else if (size.classList.contains('font-size-5')) {
            fontSize = '22px';
            root.style.setProperty('----sticky-top-left', '-12rem');
            root.style.setProperty('----sticky-top-right', '-35rem');
        }

        //change font size of the root html element
        document.querySelector('html').style.fontSize = fontSize;
    })
})


// Удаление класса active из выбранных цветов
const changeActiveColorClass = () => {
    colorPalette.forEach(colorPicker => {
        colorPicker.classList.remove('active');
    })
}

// Изменение цветов интерфейса
colorPalette.forEach(color => {
    color.addEventListener('click', () => {
        let primaryHue;
        // Удаление класса active из выбранных цветов
        changeActiveColorClass();

        if (color.classList.contains('color-1')) {
            primaryHue = 252;
        }
        else if (color.classList.contains('color-2')) {
            primaryHue = 52;
        }
        else if (color.classList.contains('color-3')) {
            primaryHue = 352;
        }
        else if (color.classList.contains('color-4')) {
            primaryHue = 152;
        }
        else if (color.classList.contains('color-5')) {
            primaryHue = 202;
        }
        color.classList.add('active');

        root.style.setProperty('--primary-color-hue', primaryHue);
    })
})


// Изменение параметров заднего фона
let lightColorLightness;
let whiteColorLightness;
let darkColorLightness;

// Изменения цветов заднего фона
const changeBg = () => {
    root.style.setProperty('--light-color-lightness', lightColorLightness);
    root.style.setProperty('--white-color-lightness', whiteColorLightness);
    root.style.setProperty('--dark-color-lightness', darkColorLightness);
}


// Изменение цвета заднего фона
Bg1.addEventListener('click', () => {
    // Добавление класса active
    Bg1.classList.add('active');

    // Удаление класса active из других
    Bg2.classList.remove('active');
    Bg3.classList.remove('active');
    // Удаление кастомных изменений
    window.location.reload();
});

Bg2.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '20%';
    lightColorLightness = '15%';

    // Добавление класса active
    Bg2.classList.add('active');

    // Удаление класса active из других
    Bg1.classList.remove('active');
    Bg3.classList.remove('active');
    changeBg();
});

Bg3.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '10%';
    lightColorLightness = '0%';

    // Добавление класса active
    Bg3.classList.add('active');

    // Удаление класса active из других
    Bg1.classList.remove('active');
    Bg2.classList.remove('active');
    changeBg();
});

// Попап для выбора действий с постом на странице пользователя

document.getElementById("post-popup-trigger").addEventListener("click", function(e) {
    e.preventDefault();
    var popup = document.getElementById("post-action-popup");
    popup.classList.toggle("active");
});

// Закрывать попап, если щелкнуто вне него
document.addEventListener("click", function(e) {
    if (e.target.id !== "post-popup-trigger" && e.target !== document.getElementById("post-action-popup")) {
        var popup = document.getElementById("post-action-popup");
        popup.classList.remove("active");
    }
});