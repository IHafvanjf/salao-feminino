document.addEventListener("DOMContentLoaded", function () {
  // elementos principais 
  const cartIconContainer = document.getElementById("cart-icon-container");
  const cartContainer     = document.getElementById("cart-container");
  const cartItemsList     = document.getElementById("cart-items");
  const checkoutButton    = document.getElementById("checkout-button");
  const searchInput       = document.getElementById("query");
  const productCards      = document.querySelectorAll(".product-card");
  const navbarElement     = document.querySelector(".navbar");

  // estado do carrinho 
  let cartItems = [];

  // helpers 
  function formatBRL(v) {
    const n = typeof v === "number" ? v : parseFloat(String(v).replace(",", ".")) || 0;
    return n.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
  }

  function addItemToCart(productTitle, productImage, productPrice) {
    const title = (productTitle || "").trim();

    const existingItem = cartItems.find((item) => item.title === title);
    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      cartItems.push({
        title,
        image: productImage,
        price: productPrice, 
        quantity: 1,
      });
    }
    updateCartDisplay();
  }

  function removeItemFromCart(productTitle) {
    cartItems = cartItems.filter((item) => item.title !== productTitle);
    updateCartDisplay();
  }

  function changeQty(title, delta) {
    const item = cartItems.find((i) => i.title === title);
    if (!item) return;
    item.quantity += delta;
    if (item.quantity <= 0) {
      cartItems = cartItems.filter((i) => i.title !== title);
    }
    updateCartDisplay();
  }

  function updateCartDisplay() {
    cartItemsList.innerHTML = "";

    let total = 0;

    cartItems.forEach((item) => {
      const priceNum = parseFloat(String(item.price).replace(",", ".")) || 0;
      const subtotal = priceNum * item.quantity;
      total += subtotal;

      const li = document.createElement("li");
      li.innerHTML = `
        <div class="cart-item">
          <img src="${item.image}" alt="${item.title}" class="cart-item-image">
          <div class="cart-item-text">
            <span class="cart-item-title">${item.title}</span>
            <span class="cart-item-price">
              ${formatBRL(priceNum)}
              ${item.quantity > 1 ? `<small> • Subtotal: ${formatBRL(subtotal)}</small>` : ""}
            </span>
          </div>

          <div class="cart-item-qty">
            <button class="qty-minus" data-title="${item.title}" aria-label="Diminuir">−</button>
            <span class="qty-value">${item.quantity}</span>
            <button class="qty-plus" data-title="${item.title}" aria-label="Aumentar">+</button>
          </div>

          <button class="remove-btn" data-title="${item.title}" aria-label="Remover">
            <img src="../img/lixeira.png" alt="Remover">
          </button>
        </div>
      `;
      cartItemsList.appendChild(li);
    });

    // listeners dos itens do carrinho
    cartItemsList.querySelectorAll(".qty-plus").forEach((btn) => {
      btn.addEventListener("click", () => changeQty(btn.dataset.title, 1));
    });
    cartItemsList.querySelectorAll(".qty-minus").forEach((btn) => {
      btn.addEventListener("click", () => changeQty(btn.dataset.title, -1));
    });
    cartItemsList.querySelectorAll(".remove-btn").forEach((btn) => {
      btn.addEventListener("click", () => removeItemFromCart(btn.dataset.title));
    });

    // mostra/oculta carrinho
    if (cartItems.length > 0) {
      cartContainer.classList.add("active");
    } else {
      cartContainer.classList.remove("active");
    }

    // total no botão
    const totalText = total > 0 ? ` (${formatBRL(total)})` : "";
    checkoutButton.textContent = "Finalizar" + totalText;

    // badge no ícone
    const count = cartItems.reduce((s, i) => s + i.quantity, 0);
    let badge = document.getElementById("cart-count");
    if (!badge) {
      badge = document.createElement("span");
      badge.id = "cart-count";
      badge.style.cssText =
        "position:absolute; top:-6px; right:-6px; background:#e11; color:#fff; border-radius:999px; padding:2px 6px; font-size:12px;";
      cartIconContainer.style.position = "relative";
      cartIconContainer.appendChild(badge);
    }
    badge.textContent = count;
    badge.style.display = count ? "inline-block" : "none";
  }

  // abrir/fechar carrinho pelo ícone 
  cartIconContainer.addEventListener("click", function () {
    cartContainer.classList.toggle("active");
  });

  // adicionar aos produtos 
  const productButtons = document.querySelectorAll(".product-button");
  productButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const card = this.closest(".product-card");
      const productTitle =
        card.querySelector(".product-title")?.textContent.trim() || "Produto";
      const productImage = card.querySelector(".product-image")?.src || "";

      // tenta pegar preço de data-attributes; se não houver, usa 99.90
      const priceAttr = this.dataset.price || card.dataset?.price;
      const productPrice = priceAttr
        ? parseFloat(String(priceAttr).replace(",", "."))
        : 99.9;

      addItemToCart(productTitle, productImage, productPrice);
    });
  });

  // finalizar (WhatsApp) 
  checkoutButton.addEventListener("click", function () {
    if (cartItems.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }

    let message = "Olá! Gostaria de finalizar minha compra:\n";
    let total = 0;

    cartItems.forEach((item) => {
      const priceNum = parseFloat(String(item.price).replace(",", ".")) || 0;
      const subtotal = priceNum * item.quantity;
      total += subtotal;
      message += `- ${item.title} (x${item.quantity}) - ${formatBRL(priceNum)}\n`;
    });

    message += `Total: ${formatBRL(total)}`;

    const whatsappNumber = "5531997941735";
    const encodedMessage = encodeURIComponent(message);
    const whatsappLink = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

    window.open(whatsappLink, "_blank");

    // limpa carrinho após finalizar
    cartItems = [];
    updateCartDisplay();
  });

  // busca de produtos 
  searchInput.addEventListener("input", function () {
    const query = this.value.toLowerCase();

    productCards.forEach((product) => {
      const title = product.querySelector(".product-title").textContent.toLowerCase();
      const description = product
        .querySelector(".product-description")
        .textContent.toLowerCase();

      product.style.display =
        title.includes(query) || description.includes(query) ? "block" : "none";
    });
  });

  // esconder ícone/carrinho ao encostar na navbar 
  window.addEventListener("scroll", function () {
    const cartIconRect = cartIconContainer.getBoundingClientRect();
    const navbarRect = navbarElement.getBoundingClientRect();

    if (cartIconRect.top < navbarRect.bottom) {
      cartIconContainer.style.opacity = "0";
      cartIconContainer.style.pointerEvents = "none";
      cartContainer.classList.remove("active");
    } else {
      cartIconContainer.style.opacity = "1";
      cartIconContainer.style.pointerEvents = "auto";
    }
  });
});
