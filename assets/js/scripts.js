const mainUrl = "http://localhost/smart-devices";

//Функция, срабатывающая при событии onclick при удалении какой-либо записи из таблицы
function remove(type, id) {
    if (confirm("Вы действительно хотите удалить эту запись?")) {
        window.location.href = `${mainUrl}/${type}/delete/${id}`;
    }
}

//Функция, забирающая значение куки с переданным 'name'
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

//Удаление из корзины
function deleteCart(type, id){
    //В куке, отвечающей за корзину лежит json. Индекс элемента - ID товара, значение - количество этого товара в корзине.
    //Получаем либо значение куки 'cart', либо undefined
    let data = getCookie(type);
    //Устанавливаем время действия новой куки (+2 дня к текущей дате)
    let date = new Date(Date.now() + 60 * 60 * 24 * 2 * 1000);
    //Проверяем существует ли кука, отвечающая за корзину
    if (typeof data !== 'undefined') {
        //Парсим в объект
        data = JSON.parse(data);

        if (data[id] > 1) {
            data[id] -= 1;
            //Преобразуем обратно в json и обновляем куку
            let jsonData = JSON.stringify(data);
            document.cookie = encodeURIComponent(type) + '=' + encodeURIComponent(jsonData) + ';' + "path=/; expires=" + date;
        } else {
            delete data[id];
            if (Object.keys(data).length === 0) {
                //Удаляем куку
                let jsonData = JSON.stringify(data);
                document.cookie = encodeURIComponent(type) + '=' + encodeURIComponent(jsonData) + ';' + "path=/; max-age=0";
            } else {
                //Преобразуем обратно в json и обновляем куку
                let jsonData = JSON.stringify(data);
                document.cookie = encodeURIComponent(type) + '=' + encodeURIComponent(jsonData) + ';' + "path=/; expires=" + date;
            }
        }
    }
        //Изменение значения возле иконки с корзиной в шапке сайта. Изменение количетва товара в информационном блоке в корзине 'Итого'
        let spanTotalItems = document.querySelector('span.total-items');
        let spanTotalItemsQuantityNumber = document.querySelector('span.total__items__quantity__number')
        if (spanTotalItems.innerHTML > '1') {
             spanTotalItems.innerHTML--;
             spanTotalItemsQuantityNumber.innerHTML = spanTotalItems.innerHTML;
        } else if (spanTotalItems.innerHTML === '1'){
            spanTotalItems.innerHTML = '';
        }
}

//Вкладка 'Корзина'
//Общая цена заказа без учета скидки
let totalItemPrice = document.querySelector('span.total__items__price__number');
//Скидка всего заказа
let totalSalePrice = document.querySelector('span.total__sale__price__number');
//Итоговая стоимость заказа с учетом скидки
let totalPayPrice = document.querySelector('span.total__pay__price__number');
//Коллекция кнопок-удаления товара из корзины
let buttonsDelete = document.querySelectorAll('button.item-delete__btn');
//Объект для форматирования чисел
let formatter = new Intl.NumberFormat("ru");
//Навешиваем событие onclick на каждую кнопку для удаления товара из корзины
for (let button of buttonsDelete) {
    button.addEventListener("click", function (event) {
        //Забираемм либо button, либо вложенный icon, на который нажал пользователь
        let iconDelete = event.target;
        //Определяем div с товаром и удаляем из разметки
        let cartItem = iconDelete.closest('div.cart-item');
        cartItem.remove();

        //Дальше нужно пересчитать стоимость 'Итого'
        //Забираем обычную стоимость товара (она есть всегда)
        let cartPrice = cartItem.querySelector('span.cart__price__number');

        //Забираем стоимость товара без скидки (если такая есть. нужна проверка)
        let cartWithoutSale = cartItem.querySelector('span.cart__without-sale__number');
        //Если товар без скидки
        if (cartWithoutSale === null) {
            cartWithoutSale = cartPrice;
        }

        //Регулярка, чтобы оставить только цифры в строке (удалить пробелы, nbsp и тд)
        const regEx = /[^\d\+]/g;
        let totalItemPriceNumbers = totalItemPrice.innerHTML.replace(regEx, '');
        let totalSalePriceNumbers = totalSalePrice.innerHTML.replace(regEx, '');
        let totalPayPriceNumbers = totalPayPrice.innerHTML.replace(regEx, '');
        let cartWithoutSaleNumbers = cartWithoutSale.innerHTML.replace(regEx, '');
        let cartPriceNumbers = cartPrice.innerHTML.replace(regEx, '');

        //Рассчитываем изменение суммы без учета скидки
        totalItemPrice.innerHTML = formatter.format(totalItemPriceNumbers - cartWithoutSaleNumbers)
        //Считаем чему равна скидка на данный товар
        let salePrice = cartWithoutSaleNumbers - cartPriceNumbers;
        //Считаем как измениться итоговая скидка заказа
        totalSalePrice.innerHTML = formatter.format(totalSalePriceNumbers - salePrice);
        //Считаем конечную стоимость 'Итого'
        totalPayPrice.innerHTML = formatter.format(totalPayPriceNumbers - cartPriceNumbers);
        //Проверяем, что пользователь удалил последний товар из корзины
        if (totalPayPrice.innerHTML === '0' || totalItemPrice.innerHTML === '0') {
            //Удаляем нужные дивы
            let divsRow = document.querySelectorAll('div.row');
            divsRow[1].remove();
            divsRow[2].remove();
            divsRow[3].remove();

            //Создаем новую разметку с текстом 'Корзина пуста'
            let divRow = document.createElement('div');
            divRow.className = 'row';
            divsRow[0].after(divRow);
            let divColLg12 = document.createElement('div');
            divColLg12.className = 'col-lg-12';
            divRow.appendChild(divColLg12);
            let div = document.createElement('div');
            div.innerHTML = 'Корзина пуста';
            divColLg12.appendChild(div);
        }
    });
}



//Добавление в корзину
function addToCart(type, id){
    //В куке, отвечающей за корзину лежит json. Индекс элемента - ID товара, значение - количество этого товара в корзине.
    //Получаем либо значение куки 'cart', либо undefined
    let data = getCookie(type);
    //Устанавливаем время действия новой куки (+2 дня)
    let date = new Date(Date.now() + 60 * 60 * 24 * 2 * 1000);
    //Проверяем существует ли кука, отвечающая за корзину
    if (typeof data !== 'undefined') {
        //Парсим в объект
        data = JSON.parse(data);
        //Если такой id уже есть, то увеличиваем на 1, если нет, то создаем и устанавливаем значение 1
        if (data[id]) {
            data[id]++;
        } else {
            data[id] = 1;
        }
    } else {
        //Делаем из переменной со значением undefined пустой объект и добавляем свойство со значением
        data = {};
        data[id] = 1;
    }

    //Преобразуем обратно в json и обновляем куку
    let jsonData = JSON.stringify(data);
    document.cookie = encodeURIComponent(type) + '=' + encodeURIComponent(jsonData) + ';' + "path=/; expires=" + date;

    //Изменение значения возле иконки с корзиной в шапке сайта
    let spanTotalItems = document.querySelector('span.total-items');
    if (spanTotalItems.innerHTML === '') {
        spanTotalItems.innerHTML = '1';
    } else {
        spanTotalItems.innerHTML++
    }

    //Информируем пользователя, что товар добавлен в корзину
    alert('Товар добавлен в корзину');
}



