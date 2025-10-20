<script>
    console.log('hello');
    
    function clearFilters() {
        document.getElementById("search").value = "";
        document.getElementById("month").value = "all";

        const allDataButtons = document.querySelectorAll(
            'button[name="type"][value="all"]'
        );

        if (allDataButtons.length > 0) {
            allDataButtons[0].click();
        }

        const rows = document.querySelectorAll("tbody tr");
        rows.forEach((row) => {
            row.style.display = "";
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('search').addEventListener("input", function () {
            let parentForm = this.closest('form')

            if (!this.value) {
                parentForm.submit()
                return
            }
            
            const query = new URLSearchParams(new FormData(parentForm)).toString();
            const newUrl = new URL(window.location);
            console.log(query);
            console.log(newUrl);
            newUrl.search = query;
            window.history.pushState({}, "", newUrl);
            
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll("tbody tr");
            const isAdmin = "{{ auth()->user()->role }}" === "admin";
            const reasonIndex = isAdmin ? 4 : 3;

            rows.forEach((row) => {
                if (row.cells.length > 1) {
                    const reason = row.textContent.toLowerCase();
                    if (reason.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
            if (rows[0].className === 'empty') {
                parentForm.submit();
                return
            }
        });

        document.querySelectorAll('.status-btn').forEach(s => {
            s.addEventListener('click', function() {
                    document.querySelectorAll('.buttonSubmit').forEach(b => {
                    b.value = this.value
                    b.closest('form').submit()
                });
            });
        });

        document.querySelectorAll(".eye-preview-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                console.log(this.dataset);
                
                const id = this.dataset.id;
                const date = this.dataset.date;
                const overworkDate = this.dataset.overwork_date;
                const start = this.dataset.start;
                const finish = this.dataset.finished;
                const type = this.dataset.type;
                const description = this.dataset.description;
                const status = this.dataset.status;
                const duration = this.dataset.duration;
                const evidences = this.dataset.evidences
                    ? JSON.parse(this.dataset.evidences)
                    : [];
                const statusClass = getStatusClass(status);
                let overworkOnly = "";
                if (type === "overwork") {
                    overworkOnly = `
                            <div class="flex flex-col items-start">
                                <span class="font-extrabold text-gray-700 capitalize">${type} Date:</span>
                                <span class="text-gray-900 mt-2 capitalize">${overworkDate}</span>
                            </div>
                            `;
                }
                let body = `
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Requested At:</span>
                            <span class="text-gray-900 mt-2">${date}</span>
                        </div>
                        ${overworkOnly}
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700 capitalize">${
                                type === "overwork"
                                    ? `${type} time`
                                    : `${type} date`
                            }:</span>
                            <span class="text-gray-900 mt-2 flex gap-5">
                                ${start} 
                                    <i class="bi bi-arrow-right text-xl font-bold"></i>
                                ${finish}
                            </span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Type:</span>
                            <span class="text-gray-900 mt-2 capitalize">${type}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Description:</span>
                            <span class="text-gray-900 mt-2">${description.replace(
                                /\n/g,
                                "<br>"
                            )}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Duration:</span>
                            <span class="text-gray-900 mt-2 capitalize">${duration}</span>
                        </div>
                        `;
                body += `
                            <div class="flex flex-col items-start">
                                <span class="font-extrabold text-gray-700">Status:</span>
                                <span class="${statusClass} capitalize">${status}</span>
                            </div>
                        `;
                if (type === "overwork") {
                    body += `
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Evidences:</span>
                            <div class="mt-2 flex flex-wrap gap-2">
                                ${evidences
                                    .map((e, index) => {
                                        const ext = e.path
                                            .split(".")
                                            .pop()
                                            .toLowerCase();
                                        if (
                                            [
                                                "jpg",
                                                "png",
                                                "jpeg",
                                                "webp",
                                            ].includes(ext)
                                        ) {
                                            return `<img src="/storage/${e.path}" alt="Evidence" class="h-[200px] rounded shadow-sm cursor-pointer evidence-item" data-index="${index}">`;
                                        } else if (
                                            ["mp4", "mov", "avi"].includes(ext)
                                        ) {
                                            return `<video src="/storage/${e.path}" class="h-[200px] rounded shadow-sm cursor-pointer evidence-item" data-index="${index}" controls></video>`;
                                        }
                                        return "";
                                    })
                                    .join("")}
                            </div>
                        </div>
                        `;
                }
                document.getElementById("dashboard-preview-body").innerHTML = body;
                currentEvidences = evidences;
                window.dispatchEvent(
                    new CustomEvent("open-modal", {
                        detail: "dashboard-preview-modal",
                    })
                );
            });
        });
    });

    function getStatusClass(status) {
        switch (status.toLowerCase()) {
            case "approved":
                return "bg-cyan-500 text-white rounded-full px-3 py-1 text-sm font-semibold";
            case "pending":
                return "bg-gray-400 text-white rounded-full px-3 py-1 text-sm font-semibold";
            case "rejected":
                return "bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold";
            default:
                return "bg-gray-500 text-white capitalize rounded-full px-3 py-1 text-sm font-semibold";
        }
    }

    let currentEvidences = [];
    let currentIndex = 0;

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("evidence-item")) {
            const index = parseInt(e.target.dataset.index);
            currentIndex = index;
            showEvidence(currentIndex);
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "evidence-viewer-modal",
                })
            );
        }
    });

    function showEvidence(index) {
        const e = currentEvidences[index];
        const ext = e.path.split(".").pop().toLowerCase();
        let mediaHtml = "";
        if (["jpg", "png", "jpeg", "webp"].includes(ext)) {
            mediaHtml = `<img src="/storage/${e.path}" alt="Evidence" class="max-w-full h-[600px] rounded shadow-lg">`;
        } else if (["mp4", "mov", "avi"].includes(ext)) {
            mediaHtml = `<video src="/storage/${e.path}" class="max-w-full h-[600px] rounded shadow-lg" controls autoplay></video>`;
        }
        document.getElementById("evidence-viewer-body").innerHTML = mediaHtml;
        document.getElementById("prev-evidence").style.display =
            index > 0 ? "block" : "none";
        document.getElementById("next-evidence").style.display =
            index < currentEvidences.length - 1 ? "block" : "none";
    }

    document
        .getElementById("prev-evidence")
        .addEventListener("click", function () {
            if (currentIndex > 0) {
                currentIndex--;
                showEvidence(currentIndex);
            }
        });

    document
        .getElementById("next-evidence")
        .addEventListener("click", function () {
            if (currentIndex < currentEvidences.length - 1) {
                currentIndex++;
                showEvidence(currentIndex);
            }
        });

    document.querySelectorAll('.rejectButton').forEach(b => {
        b.addEventListener('click', function () {
            const value = this.getAttribute('value');
            let adminNote = document.createElement('input')
            let statusData = document.createElement('input')

            let note = prompt('Sing sebutkeun alesanna mang: ');
            if (note === null) return;

            adminNote.setAttribute('type', 'hidden')
            adminNote.setAttribute('name', 'admin_note')
            adminNote.setAttribute('value', note)
            statusData.setAttribute('type', 'hidden')
            statusData.setAttribute('name', 'rejected')
            statusData.setAttribute('value', value)
            
            const form = this.closest('form')
            form.appendChild(adminNote)
            form.appendChild(statusData)

            form.submit();
            setTimeout(() => {
                adminNote.remove();
                statusData.remove();
            }, 100);
        })
    });
</script>
