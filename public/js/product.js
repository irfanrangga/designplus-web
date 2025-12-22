document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.getElementById("categorySelect");
    const materialGroups = document.querySelectorAll(".material-group");
    const noCategoryMsg = document.getElementById("noCategoryMsg");
    const designRadios = document.querySelectorAll(".design-radio");
    const customDesignDiv = document.getElementById("customDesignDiv");

    // Subtotal dan biaya tambahan desain custom
    const subtotalText = document.getElementById("subtotalText");
    const customFeeInfo = document.getElementById("customFeeInfo");
    const designTypeRadios = document.querySelectorAll(
        'input[name="design_type"]'
    );
    let basePrice = 0;
    if (subtotalText) {
        basePrice =
            parseInt(subtotalText.textContent.replace(/[^\d]/g, "")) || 0;
    }
    const customFee = 5000;

    const designPriceEl = document.getElementById("designPrice");
    function updateDesignPrice() {
        const selected = document.querySelector(
            'input[name="design_type"]:checked'
        );
        if (!designPriceEl) return;
        if (selected && selected.value === "custom") {
            designPriceEl.textContent = "Rp" + (5000).toLocaleString("id-ID");
        } else {
            designPriceEl.textContent = "Rp" + (0).toLocaleString("id-ID");
        }
    }
    if (designTypeRadios && designTypeRadios.length > 0) {
        designTypeRadios.forEach((radio) => {
            radio.addEventListener("change", updateDesignPrice);
        });
        updateDesignPrice();
    }

    // Fungsi untuk reset semua radio button (agar tidak terkirim data salah)
    function uncheckAll() {
        document
            .querySelectorAll('input[name="material"]')
            .forEach((el) => (el.checked = false));
    }

    function showGroupFor(category) {
        materialGroups.forEach((group) => group.classList.add("hidden"));
        uncheckAll();

        if (!category) {
            if (noCategoryMsg) noCategoryMsg.classList.remove("hidden");
            return;
        }

        const targetGroup = document.querySelector(
            `.material-group[data-category="${category}"]`
        );
        if (targetGroup) {
            targetGroup.classList.remove("hidden");
            if (noCategoryMsg) noCategoryMsg.classList.add("hidden");
            // Check first material option by default
            const firstRadio = targetGroup.querySelector(
                'input[name="material"]'
            );
            if (firstRadio) firstRadio.checked = true;
        }
    }

    // Event Listener saat Kategori berubah
    if (categorySelect) {
        categorySelect.addEventListener("change", function () {
            showGroupFor(this.value);
        });

        // Trigger manual saat halaman dimuat (untuk handle old input saat validasi error)
        if (categorySelect.value !== "") {
            showGroupFor(categorySelect.value);
        }
    }

    // Handle desain standard/custom
    if (designRadios.length > 0 && customDesignDiv) {
        function updateDesignDiv() {
            const selected = document.querySelector(
                'input[name="design_type"]:checked'
            );
            if (selected && selected.value === "custom") {
                customDesignDiv.classList.remove("hidden");
            } else {
                customDesignDiv.classList.add("hidden");
                // Clear file input when switching back to standard
                const file =
                    customDesignDiv.querySelector('input[type="file"]');
                if (file) file.value = null;
            }
        }

        designRadios.forEach((r) =>
            r.addEventListener("change", updateDesignDiv)
        );
        updateDesignDiv();
    }

    // Highlight selected option labels for material and warna
    function updateSelectedLabels(radioName) {
        const radios = document.querySelectorAll(`input[name="${radioName}"]`);
        radios.forEach((r) => {
            const lbl = document.querySelector(`label[for="${r.id}"]`);
            if (!lbl) return;
            if (r.checked) {
                lbl.classList.add(
                    "bg-blue-500",
                    "text-white",
                    "border-transparent",
                    "selected"
                );
                lbl.classList.remove("bg-white", "text-gray-700");
            } else {
                lbl.classList.remove(
                    "bg-blue-500",
                    "text-white",
                    "border-transparent",
                    "selected"
                );
                lbl.classList.add("bg-white", "text-gray-700");
            }
        });
    }

    // Attach change listeners and initialize state
    ["material", "warna"].forEach((name) => {
        document.querySelectorAll(`input[name="${name}"]`).forEach((r) => {
            r.addEventListener("change", () => updateSelectedLabels(name));
        });
        // init
        updateSelectedLabels(name);
    });

    // Quantity controls and total price calculation
    const unitPriceEl = document.getElementById("unitPrice");
    const totalPriceEl = document.getElementById("totalPrice");
    const qtyInput = document.getElementById("quantityInput");
    const plusBtn = document.getElementById("qtyPlus");
    const minusBtn = document.getElementById("qtyMinus");

    function formatRupiah(n) {
        return "Rp" + new Intl.NumberFormat("id-ID").format(n);
    }

    function updateTotal() {
        if (!unitPriceEl || !totalPriceEl || !qtyInput) return;
        const unit = parseInt(unitPriceEl.dataset.price) || 0;
        let qty = parseInt(qtyInput.value) || 1;
        const max = parseInt(qtyInput.dataset.max) || 9999;
        if (qty < 1) qty = 1;
        if (qty > max) qty = max;
        qtyInput.value = qty;
        // Hitung biaya desain custom
        let designCost = 0;
        const selectedDesign = document.querySelector('input[name="design_type"]:checked');
        if (selectedDesign && selectedDesign.value === "custom") {
            designCost = customFee;
        }
        // Update subtotalText dan totalPrice
        if (subtotalText) {
            subtotalText.textContent = formatRupiah((unit + designCost));
        }
        totalPriceEl.innerText = formatRupiah((unit + designCost) * qty);
    }

    if (plusBtn && minusBtn && qtyInput) {
        plusBtn.addEventListener("click", () => {
            const max = parseInt(qtyInput.dataset.max) || 9999;
            let v = parseInt(qtyInput.value) || 1;
            if (v < max) v++;
            qtyInput.value = v;
            updateTotal();
        });

        minusBtn.addEventListener("click", () => {
            let v = parseInt(qtyInput.value) || 1;
            if (v > 1) v--;
            qtyInput.value = v;
            updateTotal();
        });

        qtyInput.addEventListener("change", () => updateTotal());
    }

    // Update subtotal dan total saat desain berubah
    if (designTypeRadios && designTypeRadios.length > 0) {
        designTypeRadios.forEach((radio) => {
            radio.addEventListener("change", updateTotal);
        });
    }

    // initialize total
    updateTotal();
});

