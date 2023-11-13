jQuery(function ($) {
  $('[data-toggle]').click(function () {
    var id = $(this).attr('data-toggle');
    $(id).toggleClass('active');
    $(this).toggleClass('active');
  });
  $('.mMenu').click(function () {
    $(this).toggleClass('active');
    $('body').toggleClass('showmenu');
  });
  const $language = $('[data-language]');
  const $languagePlaceholder = $language.find('#language-placeholder');
  $languagePlaceholder.html($language.find('.current-lang a').html());

  // show / hide people-support when reload
  $pcSupporter = $('.people-support');
  if ($pcSupporter.length) {
    const currentPC = localStorage.getItem('PC_SUPPORT');
    if (currentPC && currentPC === '0') {
      localStorage.setItem('PC_SUPPORT', 1);
      $('#people-support-0').removeClass('active');
      $('#people-support-1').addClass('active');
    } else {
      localStorage.setItem('PC_SUPPORT', 0);
      $('#people-support-1').removeClass('active');
      $('#people-support-0').addClass('active');
    }
  }

  const $quickSupportDiv = $('#quick-support');
  $('#btn-support').click(function () {
    if ($quickSupportDiv.hasClass('active')) {
      $quickSupportDiv.removeClass('active');
    } else {
      $quickSupportDiv.addClass('active');
    }
  });
  $('#quick-support #btn-close').click(function () {
    $quickSupportDiv.removeClass('active');
  });

  function setToolbarLanguageClass() {
    const containerRightW =
      (window.innerWidth - $('#toolbar .container').innerWidth() + 30) / 2;

    if (containerRightW < 100) {
      $('#toolbar__inner').addClass('has-padding');
    } else {
      $('#toolbar__inner').removeClass('has-padding');
    }
  }
  setToolbarLanguageClass();
  $(window).on('resize', function () {
    if (window.innerWidth > 991) {
      setToolbarLanguageClass();
    }
  });
  // back to top
  const $toTop = $('#toTop');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $toTop.fadeIn();
    } else {
      $toTop.fadeOut();
    }
  });
  $toTop.click(function () {
    $('html, body').animate({ scrollTop: 0 }, 1000);
  });
  // set title color
  $titleColor = $('[data-color]');
  if ($titleColor.length) {
    $titleColor.each((index, title) => {
      const colorText = $(title).data('color');
      const textTitle = $(title).text().trim();
      $(title).html(textTitle.replace(colorText, `<span>${colorText}</span>`));
    });
  }
  // product category
  var categoriesLi = $('.product-category-list> li');
  categoriesLi.each(function (index, el) {
    var $childrenUl = $(this).find('ul');
    if ($childrenUl.length > 0) {
      $(this).addClass('has-child').prepend('<span class="arrow"></span>');
      $childrenUl.children('li').each(function (index, el) {
        if ($(el).hasClass('active')) {
          $childrenUl.parents('li').addClass('active');
        }
      });
    }
  });

  var catHalder = categoriesLi.children('.arrow');
  catHalder.on('click', function () {
    var childUl = $(this).parent('li').children('ul');
    if (childUl.is(':visible')) {
      childUl.slideUp(400);
      $(this).parent('li').removeClass('active');
    } else {
      childUl.slideDown(400);
      $(this).parent('li').addClass('active');
    }
  });

  // single product gallery
  $('.home-news-slider').slick({
    arrows: false,
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 1,
    rows: 0,
    prevArrow: $('.prev'),
    nextArrow: $('.next'),
    responsive: [
      {
        breakpoint: 540,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  // product gallery slider
  $('[data-gallery] .slider-nav').slick({
    dots: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: '.slider-thumb ',
  });
  $('[data-gallery] .slider-thumb').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider-nav',
    arrows: true,
    focusOnSelect: true,
    infinite: false,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
        },
      },
    ],
  });
  // tabs
  const $tabs = $('[data-tab]');
  $tabs.on('click', function (e) {
    e.preventDefault();
    const $target = $($(this).attr('href'));
    const $tabsContent = $('.tab-content');

    if ($target.length) {
      $tabsContent.removeClass('active');
      $target.addClass('active');
      $(this).addClass('active');
      $(this).parent('li').siblings().children('a').removeClass('active');
    }
  });

  // ajax loadmore product and show paging
  function pagination(
    total,
    current,
    url,
    currentSearch = '',
    nearbyPagesLimit = 4,
  ) {
    let $html = '';
    const search = urlHelper.getSearch(url);
    if (total > 1) {
      $html += '<div class="pagination">';
      let prevDisable = '';
      if (current === 1) {
        prevDisable = ' disabled';
      }
      $html += `<a class="prev page-numbers${prevDisable}" data-page="${
        current - 1
      }" href="${url}page/${current - 1}${currentSearch}">Prev</a>`;
      for (let i = 1; i <= total; i++) {
        if (current - nearbyPagesLimit - i === 0) {
          $html += `<a class="page-numbers" data-page="${i}" href="${url}page/${i}${currentSearch}">${i}</a>`;
          if (i !== 1) {
            $html += '<span class="page-numbers">...</span>';
          }
        } else if (
          current + nearbyPagesLimit - i === 0 &&
          current + nearbyPagesLimit < total
        ) {
          $html += '<span class="page-numbers">...</span>';
        } else if (current - nearbyPagesLimit - i > 0) {
          $html += '';
        } else if (current + nearbyPagesLimit - i < 0) {
          $html += '';
        } else if (current === i) {
          $html += `<span class="page-numbers current" aria-current="page">${i}</span>`;
        } else {
          $html += `<a class="page-numbers" data-page="${i}" href="${url}page/${i}${currentSearch}">${i}</a>`;
        }
      }
      if (current !== total && current + nearbyPagesLimit < total) {
        $html += `<a class="page-numbers" data-page="${total}" href="${url}page/${total}${currentSearch}">${total}</a>`;
      }

      let nextDisable = '';
      if (current >= total) {
        nextDisable = ' disabled';
      }
      $html += `<a class="next page-numbers${nextDisable}" data-page="${
        current + 1
      }" href="${url}page/${current + 1}${currentSearch}">Next</a>`;
      $html += '</div>';
    }
    return $html;
  }

  function generateNavigation() {
    const $pagination = $('#pagination');
    const totalPages = $pagination.data('max-page');
    const totalPost = $pagination.data('found-posts');
    if (totalPages > 1) {
      const currentPage = $pagination.data('page');
      const currentUrl = window.location.origin + window.location.pathname;
      const currentSearch = window.location.search;
      const paginationHTMl = pagination(
        totalPages,
        currentPage,
        currentUrl,
        currentSearch,
      );
      $pagination.html(
        `<div class="footer-pagination">${paginationHTMl}</div>`,
      );
    }
    $('#total-sort-number').removeClass('visible-hidden').text(totalPost);
  }

  // ajax load product
  function hasChecked($checkboxs) {
    var toReturn = false;
    $checkboxs.each(function () {
      if ($(this).is(':checked')) {
        toReturn = true;
        return false;
      }
    });
    return toReturn;
  }
  // ajax load product
  function ajaxLoadProduct() {
    // remove page from URL before ajax load
    const regex = /page\/\d\//gm;
    const newPath = document.location.href.replace(regex, '');
    urlHelper.replaceUrl(newPath);

    const $list = $('#product-ajax-load');
    let queryData = urlHelper.getQuery(document.location.href);
    let curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    const currentCategory = $('[data-current-category]').data(
      'current-category',
    );
    if (currentCategory) {
      queryData = { ...queryData, taxanomy: currentCategory };
    }
    queryData = { ...queryData, lang: curLang[0] };

    $.ajax({
      type: 'POST',
      url: frontendajax.ajax_url,
      data: {
        data: queryData,
        action: 'loadmore_product',
      },
      beforeSend() {
        $('#total-sort-number').addClass('visible-hidden');
        $list.empty().append('<span class="loading"></span>');
      },
      success: function (data) {
        $list.append(data);
        $('#product-ajax-load .loading').remove();
        generateNavigation();
      },
      error: function () {
        console.log('error');
        $('#product-ajax-load .loading').remove();
      },
    });
  }

  function handleCheckBoxes($this) {
    var $checkboxList = $this
      .closest('.filter-content')
      .find('input[type="checkbox"]');
    var name = $this[0].name;
    var value = $this[0].value;

    urlHelper.reomveQueryString(document.location.href, 'page');
    if (hasChecked($checkboxList)) {
      var myCheckboxes = new Array();
      $checkboxList.each(function () {
        if ($(this).is(':checked')) {
          myCheckboxes.push($(this).val());
        } else {
          const index = myCheckboxes.indexOf($(this).val());
          if (index !== -1) {
            myCheckboxes.splice(index, 1);
          }
        }
      });
      if (myCheckboxes.length) {
        value = myCheckboxes.join();
      }
      const query = urlHelper.appendQuery(document.location.href, {
        [name]: value,
      });
      urlHelper.replaceUrl(query);
    } else {
      urlHelper.reomveQueryString(document.location.href, name);
    }
    ajaxLoadProduct();
  }

  var $checkbox = $('.filter-content .checkbox-filter');
  $checkbox.on('click', function () {
    handleCheckBoxes($(this));
  });
  $('[data-product-filter]').on('click', function (e) {
    e.preventDefault();
    urlHelper.reomveQueryString(document.location.href, 'page');
    const $this = $(e.target);
    $('[data-product-filter]').removeClass('active');
    $this.addClass('active');
    const category = $this.data('product-filter');
    const query = urlHelper.appendQuery(document.location.href, {
      taxanomy: category,
    });
    if (category !== 'all') {
      urlHelper.replaceUrl(query);
    } else {
      urlHelper.reomveQueryString(document.location.href, 'taxanomy');
    }
    ajaxLoadProduct();
  });
  $('#sortBy').on('change', function (e) {
    e.preventDefault();
    const { value } = e.target;
    if (value) {
      const query = urlHelper.appendQuery(document.location.href, {
        sort: value,
      });
      urlHelper.replaceUrl(query);
    } else {
      urlHelper.reomveQueryString(document.location.href, 'sort');
    }
    ajaxLoadProduct();
  });

  const $cartForm = $('#cart-form');
  const $cartFormMess = $('#cart-message');
  // validate cart form
  $cartForm
    .submit(function (e) {
      e.preventDefault();
    })
    .validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        phone: {
          required: true,
        },
        address: {
          required: true,
        },
        email: {
          required: true,
          email: true,
        },
        message: {
          required: true,
          minlength: 5,
        },
        agree: 'required',
        captcha: 'required',
      },
      submitHandler: function (form) {
        const curLang = document
          .getElementsByTagName('html')[0]
          .getAttribute('lang')
          .split('-');
        const cartData = JSON.parse(localStorage.getItem('cartList'));
        const data = $('#cart-form').serialize().split('&');
        const formData = {};
        for (var key in data) {
          formData[data[key].split('=')[0]] = data[key].split('=')[1];
        }
        queryData = { formData, cartItems: cartData, lang: curLang[0] };
        url = $(form).attr('action');
        $.ajax({
          type: 'POST',
          url: url,
          data: queryData,
          beforeSend() {
            $('#cart-table').addClass('is-loading');
            $('#cart-form')
              .addClass('is-loading')
              .append('<span class="loading"></span>');
          },
          success: function (result) {
            $('#cart-table').removeClass('is-loading');
            $('#cart-form').removeClass('is-loading');
            $('#cart-form .loading').remove();
            let messageText = result;
            if (result === 'invalid_captchat') {
              messageText = $cartFormMess.data('invalid-captcha');
              $('[name="captcha"]').focus();
            } else if (result === 'empty_captchat') {
              messageText = $cartFormMess.data('empty-captcha');
              $('[name="captcha"]').focus();
            } else if (result == 'Invalid list ID.') {
              messageText = $cartFormMess.data('invalid-list-text');
            } else if (result == 'Already subscribed.') {
              messageText = $cartFormMess.data('already-text');
            } else if (result == '1') {
              messageText = $cartFormMess.data('success-text');
            }
            $cartFormMess.text(messageText);

            if (result == '1') {
              $cartFormMess.css('color', 'green');
              localStorage.removeItem('cartList');
              $('#cart-form').removeClass('form-error');
              $('#cart-form')[0].reset();
              $('#cart-form').addClass('hidden');
              ajaxLoadCartList();
              setTotalCartNumber();
            } else {
              $cartFormMess.css('color', 'red');
            }
          },
          error: function (error) {
            $('#cart-table').removeClass('is-loading');
            $('#cart-form').removeClass('is-loading');
            $('#cart-form .loading').remove();
            console.error(error);
          },
        });
        return false;
      },
    });

  // validate subscription_form
  const $subscriptionForm = $('#subscription_form');
  const $subscriptionFormStatus = $('#subscription_form_status');
  $subscriptionForm
    .submit(function (e) {
      e.preventDefault();
    })
    .validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          email: true,
        },
        Mobile: {
          required: true,
        },
      },
      submitHandler: function (form) {
        // form.submit();
        const formData = {};
        const formDataArr = $(form).serializeArray();
        formDataArr.forEach((element) => {
          formData[element.name] = element.value;
        });
        url = $(form).attr('action');
        $.ajax({
          type: 'POST',
          url,
          data: formData,
          beforeSend() {
            $subscriptionForm
              .addClass('is-loading')
              .append('<span class="loading"></span>');
          },
          success: function (data) {
            $subscriptionForm[0].reset();
            $('#subscription_form .loading').remove();
            $subscriptionForm.removeClass('is-loading');

            if (data) {
              if (data == 'Invalid list ID.') {
                const text = $subscriptionFormStatus.data('invalid-list-text');
                $subscriptionFormStatus.text(text);
                $subscriptionFormStatus.css('color', 'red');
              } else if (data == 'Already subscribed.') {
                const text2 = $subscriptionFormStatus.data('already-text');
                $subscriptionFormStatus.text(text2);
                $subscriptionFormStatus.css('color', 'red');
              } else {
                const text3 = $subscriptionFormStatus.data('success-text');
                const subText =
                  $subscriptionFormStatus.data('success-sub-text');
                const img = $subscriptionFormStatus.data('image');
                $subscriptionForm.addClass('hidden');
                $subscriptionFormStatus.html(
                  `<p class="text-center">${text3}</p><p class="text-center"><img src="${img}"/ ></p><p class="text-center">${subText}</p>`,
                );
                $subscriptionFormStatus.css('color', 'green');
              }
            }
            setTimeout(() => {
              $subscriptionFormStatus.text('');
              $subscriptionForm.removeClass('hidden');
            }, 10000);
          },
          error: function (err) {
            $('#subscription_form .loading').remove();
            $subscriptionForm.removeClass('is-loading');
            console.log(err);
          },
        });
        return false;
      },
    });

  function setTotalCartNumber() {
    let total = 0;
    const curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    const cartListJson = JSON.parse(localStorage.getItem('cartList'));
    if (cartListJson) {
      const totalshoppingCartStorage = cartListJson.reduce((acc, curr) => {
        if (curr.lang === curLang[0]) {
          return acc + curr.quantity;
        }
        return acc;
      }, 0);
      total = totalshoppingCartStorage;
    }
    $('.cart-number').html(total > 0 ? total : '');
    if (total > 0) {
      $('.cart-number').addClass('has-cart');
    } else {
      $('.cart-number').removeClass('has-cart');
    }
  }

  // cart menu
  const shoppingCartStorage = JSON.parse(localStorage.getItem('cartList'));
  if (!shoppingCartStorage && $cartForm?.length) {
    $cartForm.addClass('hidden');
  }

  $shoppingCartMenu = $('.shopping-cart-menu a');
  if ($shoppingCartMenu?.length) {
    const curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    let total = 0;
    if (shoppingCartStorage) {
      const totalshoppingCartStorage = shoppingCartStorage.reduce(
        (acc, curr) => {
          if (curr.lang === curLang[0]) {
            return acc + curr.quantity;
          }
          return acc;
        },
        0,
      );
      total = totalshoppingCartStorage;
    }
    $shoppingCartMenu.append(
      `<span class="cart-icon"><i class="${
        total > 0 ? 'cart-number has-cart' : 'cart-number'
      }">${total > 0 ? total : ''}</i></span>`,
    );
    $('.mobile-cart .cart-number').text(total > 0 ? total : '');
    if (total > 0) {
      $('.cart-number').addClass('has-cart');
    } else {
      $('.cart-number').removeClass('has-cart');
    }
  }
  // add to cart
  function updateCartStorage(id, newQty) {
    let cartList = [];
    const foundIndex = shoppingCartStorage.findIndex((x) => {
      return x.productId === id;
    });
    shoppingCartStorage[foundIndex].quantity = newQty;
    cartList = shoppingCartStorage;
    localStorage.setItem('cartList', JSON.stringify(cartList));
    setTotalCartNumber();
  }

  function deleteCartStorage(id) {
    const foundIndex = shoppingCartStorage.findIndex((x) => {
      return x.productId === id;
    });

    if (foundIndex > -1) {
      shoppingCartStorage.splice(foundIndex, 1);
    }
    localStorage.setItem('cartList', JSON.stringify(shoppingCartStorage));
    ajaxLoadCartList();
    setTotalCartNumber();
  }

  $(document).on('click', '[data-cart-id]', (e) => {
    $(e.target).addClass('disabled');
    const curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');

    const productId = $(e.target).data('cart-id');
    let cartList = [];

    if (shoppingCartStorage) {
      const foundIndex = shoppingCartStorage.findIndex((x) => {
        return x.productId === productId;
      });
      if (foundIndex > -1) {
        shoppingCartStorage[foundIndex].quantity =
          shoppingCartStorage[foundIndex].quantity + 1;
      } else {
        shoppingCartStorage.push({
          productId: productId,
          quantity: 1,
          lang: curLang[0],
        });
      }
      cartList = shoppingCartStorage;
    } else {
      cartList.push({ productId: productId, quantity: 1, lang: curLang[0] });
    }
    localStorage.setItem('cartList', JSON.stringify(cartList));
    window.location = $(e.target).data('href');
  });

  // ajax load cart listing
  function ajaxLoadCartList() {
    const cartStorage = JSON.parse(localStorage.getItem('cartList'));
    const $list = $('#cart-table');
    const curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    queryData = { cartItems: cartStorage, lang: curLang[0] };

    $.ajax({
      type: 'POST',
      url: frontendajax.ajax_url,
      data: {
        data: queryData,
        action: 'load_cart',
      },
      beforeSend() {
        $list.empty();
        $list.addClass('is-loading');
      },
      success: function (data) {
        if (typeof data === 'string') {
          $list.append(data);
        } else {
          // empty list
          $list.append(data.data.html);
          $('.cart-number').removeClass('has-cart').html('');
          $('#cart-form').addClass('hidden');
        }
        $list.removeClass('is-loading');
      },
      error: function () {
        console.log('error');
        $list.removeClass('is-loading');
        $('#cart-form').addClass('hidden');
      },
    });
  }

  const $cartTable = $('#cart-table');
  if ($cartTable?.length) {
    ajaxLoadCartList();
  }
  // cart actions
  function handleConfirmDeleteCart(id) {
    const curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    $.confirm({
      title: curLang === 'en' ? 'Confirm!' : 'Xác nhận!',
      content:
        curLang === 'en'
          ? 'Are you sure want to remove product from cart?'
          : 'Bạn có chắc chắn muốn xóa sản phẩm khỏi giỏ hàng?',
      buttons: {
        yes: {
          text: 'Yes',
          btnClass: 'btn-primary',
          action: function () {
            deleteCartStorage(id);
          },
        },
        close: function () {},
      },
    });
  }

  function inCreaseDecreaseCartNumber() {
    $(document).on('click', '.cart-item .plus', function (e) {
      const $productRow = $(this).closest('.cart-item');
      const $rowNumber = $productRow.find('.number');
      const productId = $productRow.data('id');
      const newVal = +$rowNumber.text() + 1;
      $rowNumber.html(newVal);
      updateCartStorage(+productId, newVal);
    });
    $(document).on('click', '.cart-item .minus', function (e) {
      const $productRow = $(this).closest('.cart-item');
      const $rowNumber = $productRow.find('.number');
      const productId = $productRow.data('id');
      const newVal = +$rowNumber.text() - 1;
      if (+newVal === 0) {
        handleConfirmDeleteCart(+productId);
      } else {
        $rowNumber.html(newVal);
        updateCartStorage(+productId, newVal);
      }
    });
  }

  inCreaseDecreaseCartNumber();

  $(document).on('click', '.cart-item .delete', function (e) {
    const $productRow = $(this).closest('.cart-item');
    const productId = $productRow.data('id');
    handleConfirmDeleteCart(+productId);
  });

  ///load region
  const $region = $('#region');
  function getCountries() {
    $.ajax({
      type: 'GET',
      url: `${frontendajax.templateUrl}/data/countries.json`,
      success: function (data) {
        console.log({ data: typeof data });
        const countriesData =
          typeof data === 'object' ? data : JSON.parse(data);
        let html = '';
        if (countriesData?.length) {
          countriesData.forEach((op) => {
            html = `${html}<option value="${op.name}">${op.name}</option>`;
          });
        }
        if ($region?.length) {
          $region.html(html);
          $region[0].value = 'Viet Nam';
        }
      },
      error: function () {
        console.log('error');
      },
    });
  }
  if ($('#cart-form')?.length) {
    getCountries();
  }

  const $ajaxDiv = $('#home-product-ajax');
  const $relatedProduct = $('.related-product-slider');
  function setProductHomeHeight() {
    const height = $relatedProduct.outerHeight();
    $ajaxDiv.css('minHeight', `${height}px`);
  }
  if ($relatedProduct?.length) {
    setProductHomeHeight();
  }
  // product home slider
  function setProductHomeSlider() {
    // product gallery slider
    $('[data-gallery-home] .slider-nav').slick({
      dots: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      asNavFor: '.slider-thumb ',
    });
    $('[data-gallery-home] .slider-thumb').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.slider-nav',
      arrows: true,
      focusOnSelect: true,
      infinite: false,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
          },
        },
      ],
    });
  }
  setProductHomeSlider();
  // ajax load product home page
  function ajaxLoadProductHome(pId) {
    let curLang = document
      .getElementsByTagName('html')[0]
      .getAttribute('lang')
      .split('-');
    const queryData = { productId: pId, lang: curLang[0] };
    $.ajax({
      type: 'POST',
      url: frontendajax.ajax_url,
      data: {
        data: queryData,
        action: 'load_single_product',
      },
      beforeSend() {
        $ajaxDiv.empty().append('<span class="loading"></span>');
      },
      success: function (data) {
        $ajaxDiv.append(data);
        $('#home-product-ajax .loading').remove();
        setProductHomeSlider();
        setProductHomeHeight();
        $('html, body').animate(
          {
            scrollTop: $('#home-products-block').offset().top,
          },
          100,
        );
      },
      error: function () {
        console.log('error');
        $('#home-product-ajax .loading').remove();
      },
    });
  }

  $loadProductHomeTag = $('.home-product-controls [data-id]');
  $loadProductHomeTag.on('click', (e) => {
    e.preventDefault();
    const $this = $(e.target);
    $loadProductHomeTag.removeClass('active');
    $this.addClass('active');
    const pId = $this.data('id');
    ajaxLoadProductHome(pId);
  });
  //Refresh Captcha
  $('#reload-capcha').click(function () {
    const capchaUrl = $('#capcha').attr('src');
    $('#capcha').attr('src', `${capchaUrl}?` + new Date().getTime());
  });

  // validate contact form
  const $contactForm = $('#contact-form');
  const $contactFormStatus = $('#contact_form_status');
  $contactForm
    .submit(function (e) {
      e.preventDefault();
    })
    .validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          email: true,
        },
        Mobile: {
          required: true,
        },
        REGION: {
          required: true,
        },
        MESSAGE: {
          required: true,
        },
      },
      submitHandler: function (form) {
        const formData = {};
        const formDataArr = $(form).serializeArray();
        formDataArr.forEach((element) => {
          formData[element.name] = element.value;
        });
        url = $(form).attr('action');
        $.ajax({
          type: 'POST',
          url,
          data: formData,
          beforeSend() {
            $contactForm
              .addClass('is-loading')
              .append('<span class="loading"></span>');
          },
          success: function (data) {
            $contactForm[0].reset();
            $contactForm.removeClass('is-loading');
            $('#contact-form .loading').remove();
            if (data) {
              if (data == 'Invalid list ID.') {
                const text = $contactFormStatus.data('invalid-list-text');
                $contactFormStatus.text(text);
                $contactFormStatus.css('color', 'red');
              } else if (data == 'Already subscribed.') {
                const text2 = $contactFormStatus.data('already-text');
                $contactFormStatus.text(text2);
                $contactFormStatus.css('color', 'red');
              } else {
                const text3 = $contactFormStatus.data('success-text');
                $contactFormStatus.text(text3);
                $contactFormStatus.css('color', 'green');
              }
            }
            setTimeout(() => {
              $contactFormStatus.text('');
            }, 10000);
          },
          error: function (err) {
            $('#contact-form .loading').remove();
            $contactForm.removeClass('is-loading');
            console.log(err);
          },
        });
        return false;
      },
    });

  const $helpFormBlock = $('.help-form-block');
  const $helpFormBlockInactive = $helpFormBlock.find('.inactive-box');
  const $helpFormBox = $helpFormBlock.find('#help-form-box');
  const $helpForm = $helpFormBlock.find('form');
  const $closeFormBtn = $helpFormBlock.find('#btn-close');
  const $helpFormSuccess = $helpFormBlock.find('#help-form__success');
  const $helpFormSuccessCloseBtn = $helpFormBlock.find('#btn-close-success');
  const $helpFormStatusError = $helpFormBlock.find('#help_form_status');
  const $helpFormStatusSuccess = $helpFormBlock.find('#help-form__success');
  // show inactive box when load page
  setTimeout(() => {
    $helpFormBlockInactive.removeClass('hide').addClass('show');
  }, 200);

  $helpFormBlockInactive.on('click', (e) => {
    e.preventDefault();
    $helpFormBlockInactive.removeClass('show').addClass('hide');
    setTimeout(() => {
      $helpFormBox.removeClass('hide').addClass('show');
    });
  });

  function closeForm() {
    $helpFormBox.removeClass('show').addClass('hide');
    setTimeout(() => {
      $helpFormBlockInactive.removeClass('hide').addClass('show');
    }, 200);
  }
  $closeFormBtn.on('click', (e) => {
    e.preventDefault();
    closeForm();
  });
  function closeSuccessBox() {
    $helpFormSuccess.removeClass('show').addClass('hide');
    setTimeout(() => {
      $helpFormBlockInactive.removeClass('hide').addClass('show');
    }, 200);
  }
  $helpFormSuccessCloseBtn.on('click', (e) => {
    e.preventDefault();
    closeSuccessBox();
  });

  $helpForm
    .submit(function (e) {
      e.preventDefault();
    })
    .validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          email: true,
        },
        phone: {
          required: true,
        },
        company: {
          required: true,
        },
        city: {
          required: true,
        },
        region: {
          required: true,
        },
        message: {
          required: true,
        },
      },
      submitHandler: function (form) {
        const formData = {};
        const formDataArr = $(form).serializeArray();
        formDataArr.forEach((element) => {
          formData[element.name] = element.value;
        });
        url = $(form).attr('action');
        $.ajax({
          type: 'POST',
          url,
          data: formData,
          beforeSend() {
            $helpFormStatusError.addClass('hidden');
            $helpFormBox
              .addClass('is-loading')
              .append('<span class="loading"></span>');
          },
          success: function (data) {
            $helpFormBox.removeClass('is-loading');
            $('#help-form-box .loading').remove();
            if (data) {
              if (data == 'Invalid list ID.') {
                const text = $helpFormStatusError.data('invalid-list-text');
                $helpFormStatusError.text(text);
                $helpFormStatusError.removeClass('hidden');
              } else if (data == 'Already subscribed.') {
                const text2 = $helpFormStatusError.data('already-text');
                $helpFormStatusError.text(text2);
                $helpFormStatusError.removeClass('hidden');
              } else {
                $helpForm[0].reset();
                $helpFormBox.removeClass('show').addClass('hide');
                setTimeout(() => {
                  $helpFormStatusSuccess.removeClass('hide').addClass('show');
                }, 200);
                setTimeout(() => {
                  closeSuccessBox();
                }, 3000);
              }
            }
            setTimeout(() => {
              $helpFormStatusError.text('');
            }, 10000);
          },
          error: function (err) {
            $('#help-form-box .loading').remove();
            $helpFormBox.removeClass('is-loading');
            console.log(err);
          },
        });
        return false;
      },
    });
});
