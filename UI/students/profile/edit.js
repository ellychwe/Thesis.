document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ edit.js loaded");

    const editButtons = document.querySelectorAll(".edit-btn");

    editButtons.forEach(button => {
        button.addEventListener("click", () => {
            const section = button.closest(".bottom-section") || button.closest(".section");
            const infoGrid = section.querySelector(".info-grid");
            const isEditing = button.textContent === "Save";

            if (!infoGrid) {
                handleProfileSection(section, button, isEditing);
                return;
            }

            if (!isEditing) {
                button.textContent = "Save";

                // Add Cancel Button
                let cancelBtn = section.querySelector(".cancel-btn");
                if (!cancelBtn) {
                    cancelBtn = createCancelButton(button, infoGrid);
                }

                // Save Original HTML for Cancel
                cancelBtn.dataset.originalHTML = infoGrid.innerHTML;

                // Convert text into input fields
                const paragraphs = infoGrid.querySelectorAll("p");
                paragraphs.forEach(p => {
                    const label = p.querySelector("span").textContent;
                    const value = p.childNodes[1].nodeValue.trim();

                    let inputType = "text";
                    if (label === "Email Address") inputType = "email";
                    if (label === "Phone Number") inputType = "tel";
                    if (label === "Age") inputType = "number";

                    if (label === "Gender") {
                        p.innerHTML = `<span>${label}</span>
                            <select>
                                <option value="Female" ${value === "Female" ? "selected" : ""}>Female</option>
                                <option value="Male" ${value === "Male" ? "selected" : ""}>Male</option>
                            </select>`;
                    } else {
                        p.innerHTML = `<span>${label}</span><input type="${inputType}" value="${value}">`;
                    }
                });

            } else {
                // Save changes
                const paragraphs = infoGrid.querySelectorAll("p");
                paragraphs.forEach(p => {
                    const label = p.querySelector("span").textContent;
                    const inputElement = p.querySelector("input, select");
                    const inputValue = inputElement.value;
                    p.innerHTML = `<span>${label}</span>${inputValue}`;
                });

                button.textContent = "Edit";
                const cancelBtn = section.querySelector(".cancel-btn");
                if (cancelBtn) cancelBtn.remove();
            }
        });
    });

    // ✅ Helper for Cancel button
    function createCancelButton(editBtn, infoGrid) {
        const cancelBtn = document.createElement("button");
        cancelBtn.textContent = "Cancel";
        cancelBtn.className = "cancel-btn";

        const btnWrapper = document.createElement("div");
        btnWrapper.className = "edit-controls";
        btnWrapper.style.display = "inline-flex";
        btnWrapper.style.gap = "10px";

        editBtn.insertAdjacentElement("afterend", btnWrapper);
        btnWrapper.appendChild(editBtn);
        btnWrapper.appendChild(cancelBtn);

        cancelBtn.addEventListener("click", () => {
            infoGrid.innerHTML = cancelBtn.dataset.originalHTML;
            editBtn.textContent = "Edit";
            cancelBtn.remove();
        });

        return cancelBtn;
    }
});
