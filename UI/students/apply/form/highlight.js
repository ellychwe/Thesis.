const path = window.location.pathname.toLowerCase();
        console.log("Current path:", path); // ✅ Check what it prints

        if (path.includes("/apply/apply.html")) {
            document.querySelector(".breadcrumb-item.home").classList.add("active");
        }

        if (path.includes("/apply/form/form.html")) {
            document.querySelector(".breadcrumb-item.form").classList.add("active");
        }