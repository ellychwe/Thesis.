document.getElementById("section").addEventListener("change", function () {
            const otherInput = document.getElementById("other-section");
            if (this.value === "other") {
            otherInput.style.display = "block";
            otherInput.setAttribute("required", "required");
            } else {
            otherInput.style.display = "none";
            otherInput.removeAttribute("required");
            }
        });