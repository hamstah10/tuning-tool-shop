(function () {
    'use strict';

    const TuningToolShop = {
        selectors: {
            addToCartForm: '.js-add-to-cart-form',
            addToCartButton: '.js-add-to-cart',
            cartQuantityInput: '.js-cart-quantity',
            cartUpdateForm: '.js-cart-update-form',
            cartRemoveButton: '.js-cart-remove',
            sameAsBillingCheckbox: '.js-same-as-billing',
            shippingAddressFields: '.js-shipping-address',
            checkoutForm: '.js-checkout-form',
            cartItemCount: '.js-cart-item-count',
            cartTotal: '.js-cart-total',
            messageContainer: '.js-shop-messages'
        },

        init: function () {
            this.bindAddToCart();
            this.bindCartQuantityChange();
            this.bindCartRemove();
            this.bindAddressCopy();
            this.bindFormValidation();
        },

        bindAddToCart: function () {
            const forms = document.querySelectorAll(this.selectors.addToCartForm);
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleAddToCart(form);
                });
            });

            const buttons = document.querySelectorAll(this.selectors.addToCartButton);
            buttons.forEach(button => {
                if (!button.closest(this.selectors.addToCartForm)) {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.handleAddToCartButton(button);
                    });
                }
            });
        },

        handleAddToCart: function (form) {
            const formData = new FormData(form);
            const button = form.querySelector('button[type="submit"]');
            const originalText = button ? button.textContent : '';

            if (button) {
                button.disabled = true;
                button.textContent = '...';
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateCartDisplay(data);
                        this.showMessage(data.message || 'Produkt wurde in den Warenkorb gelegt', 'success');
                    } else {
                        this.showMessage(data.message || 'Fehler beim Hinzufügen', 'error');
                    }
                })
                .catch(() => {
                    this.showMessage('Ein Fehler ist aufgetreten', 'error');
                })
                .finally(() => {
                    if (button) {
                        button.disabled = false;
                        button.textContent = originalText;
                    }
                });
        },

        handleAddToCartButton: function (button) {
            const productId = button.dataset.productId;
            const quantity = button.dataset.quantity || 1;
            const actionUrl = button.dataset.actionUrl;

            if (!productId || !actionUrl) return;

            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = '...';

            const formData = new FormData();
            formData.append('tx_tuningtoolshop_cart[productId]', productId);
            formData.append('tx_tuningtoolshop_cart[quantity]', quantity);

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateCartDisplay(data);
                        this.showMessage(data.message || 'Produkt wurde in den Warenkorb gelegt', 'success');
                    } else {
                        this.showMessage(data.message || 'Fehler beim Hinzufügen', 'error');
                    }
                })
                .catch(() => {
                    this.showMessage('Ein Fehler ist aufgetreten', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                });
        },

        bindCartQuantityChange: function () {
            const inputs = document.querySelectorAll(this.selectors.cartQuantityInput);
            inputs.forEach(input => {
                let debounceTimer;
                input.addEventListener('change', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        this.handleQuantityChange(input);
                    }, 300);
                });
            });
        },

        handleQuantityChange: function (input) {
            const form = input.closest(this.selectors.cartUpdateForm);
            if (!form) return;

            const itemId = input.dataset.itemId;
            const quantity = parseInt(input.value, 10);

            if (quantity < 1) {
                input.value = 1;
                return;
            }

            const formData = new FormData();
            formData.append('tx_tuningtoolshop_cart[itemId]', itemId);
            formData.append('tx_tuningtoolshop_cart[quantity]', quantity);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateCartDisplay(data);
                        if (data.itemTotal) {
                            const row = input.closest('tr, .cart-item');
                            if (row) {
                                const totalCell = row.querySelector('.js-item-total');
                                if (totalCell) {
                                    totalCell.textContent = data.itemTotal;
                                }
                            }
                        }
                    } else {
                        this.showMessage(data.message || 'Fehler beim Aktualisieren', 'error');
                    }
                })
                .catch(() => {
                    this.showMessage('Ein Fehler ist aufgetreten', 'error');
                });
        },

        bindCartRemove: function () {
            const buttons = document.querySelectorAll(this.selectors.cartRemoveButton);
            buttons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.handleCartRemove(button);
                });
            });
        },

        handleCartRemove: function (button) {
            const itemId = button.dataset.itemId;
            const actionUrl = button.dataset.actionUrl || button.href;

            if (!itemId || !actionUrl) return;

            const formData = new FormData();
            formData.append('tx_tuningtoolshop_cart[itemId]', itemId);

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = button.closest('tr, .cart-item');
                        if (row) {
                            row.remove();
                        }
                        this.updateCartDisplay(data);
                        if (data.cartEmpty) {
                            location.reload();
                        }
                    } else {
                        this.showMessage(data.message || 'Fehler beim Entfernen', 'error');
                    }
                })
                .catch(() => {
                    this.showMessage('Ein Fehler ist aufgetreten', 'error');
                });
        },

        bindAddressCopy: function () {
            const checkbox = document.querySelector(this.selectors.sameAsBillingCheckbox);
            if (!checkbox) return;

            checkbox.addEventListener('change', () => {
                this.handleAddressCopy(checkbox.checked);
            });

            if (checkbox.checked) {
                this.handleAddressCopy(true);
            }
        },

        handleAddressCopy: function (isSame) {
            const shippingFields = document.querySelector(this.selectors.shippingAddressFields);
            if (!shippingFields) return;

            if (isSame) {
                shippingFields.style.display = 'none';
                const inputs = shippingFields.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.removeAttribute('required');
                });
            } else {
                shippingFields.style.display = 'block';
                const inputs = shippingFields.querySelectorAll('[data-required]');
                inputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            }
        },

        bindFormValidation: function () {
            const form = document.querySelector(this.selectors.checkoutForm);
            if (!form) return;

            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });

            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });
                input.addEventListener('input', () => {
                    this.clearFieldError(input);
                });
            });
        },

        validateForm: function (form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                const firstError = form.querySelector('.has-error, .is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            return isValid;
        },

        validateField: function (field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            this.clearFieldError(field);

            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Dieses Feld ist erforderlich';
            }

            if (isValid && field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Bitte geben Sie eine gültige E-Mail-Adresse ein';
                }
            }

            if (isValid && field.type === 'number' && value) {
                const min = field.getAttribute('min');
                if (min && parseFloat(value) < parseFloat(min)) {
                    isValid = false;
                    errorMessage = `Mindestmenge ist ${min}`;
                }
            }

            if (!isValid) {
                this.showFieldError(field, errorMessage);
            }

            return isValid;
        },

        showFieldError: function (field, message) {
            field.classList.add('is-invalid', 'has-error');

            const wrapper = field.closest('.form-group, .field-wrapper') || field.parentNode;
            let errorElement = wrapper.querySelector('.field-error, .invalid-feedback');

            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'field-error invalid-feedback';
                field.parentNode.insertBefore(errorElement, field.nextSibling);
            }

            errorElement.textContent = message;
            errorElement.style.display = 'block';
        },

        clearFieldError: function (field) {
            field.classList.remove('is-invalid', 'has-error');

            const wrapper = field.closest('.form-group, .field-wrapper') || field.parentNode;
            const errorElement = wrapper.querySelector('.field-error, .invalid-feedback');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        },

        updateCartDisplay: function (data) {
            if (data.cartItemCount !== undefined) {
                const countElements = document.querySelectorAll(this.selectors.cartItemCount);
                countElements.forEach(el => {
                    el.textContent = data.cartItemCount;
                });
            }

            if (data.cartTotal !== undefined) {
                const totalElements = document.querySelectorAll(this.selectors.cartTotal);
                totalElements.forEach(el => {
                    el.textContent = data.cartTotal;
                });
            }

            if (data.subtotal !== undefined) {
                const subtotalElement = document.querySelector('.js-cart-subtotal');
                if (subtotalElement) {
                    subtotalElement.textContent = data.subtotal;
                }
            }

            if (data.tax !== undefined) {
                const taxElement = document.querySelector('.js-cart-tax');
                if (taxElement) {
                    taxElement.textContent = data.tax;
                }
            }
        },

        showMessage: function (message, type) {
            let container = document.querySelector(this.selectors.messageContainer);

            if (!container) {
                container = document.createElement('div');
                container.className = 'shop-messages js-shop-messages';
                const main = document.querySelector('main, .main-content, body');
                main.insertBefore(container, main.firstChild);
            }

            const messageElement = document.createElement('div');
            messageElement.className = `shop-message shop-message--${type} alert alert-${type === 'error' ? 'danger' : type}`;
            messageElement.textContent = message;

            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'shop-message__close close';
            closeButton.innerHTML = '&times;';
            closeButton.addEventListener('click', () => {
                messageElement.remove();
            });

            messageElement.appendChild(closeButton);
            container.appendChild(messageElement);

            setTimeout(() => {
                messageElement.remove();
            }, 5000);
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => TuningToolShop.init());
    } else {
        TuningToolShop.init();
    }

    window.TuningToolShop = TuningToolShop;
})();

$(function() {
	$('.image-div').matchHeight();
    const offcanvasElementList = document.querySelectorAll('.offcanvas')
const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))
});
