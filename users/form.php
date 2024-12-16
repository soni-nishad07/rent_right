<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multistep form</title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>
    <div class="container">
        <header>Signup Form</header>
        <div class="progress-bar">
            <div class="step">
                <p>Name</p>
                <div class="bullet">
                    <span>1</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Contact</p>
                <div class="bullet">
                    <span>2</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Birth</p>
                <div class="bullet">
                    <span>3</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Debt</p>
                <div class="bullet">
                    <span>4</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Adress</p>
                <div class="bullet">
                    <span>5</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Submit</p>
                <div class="bullet">
                    <span>6</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
        </div>
        <div class="form-outer">
            <form action="#">

                <div class="page slide-page">
                    <div class="title">Basic Info:</div>
                    <div class="field">
                        <div class="label">First Name</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Last Name</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <button class="firstNext next">Next</button>
                    </div>
                </div>

                <div class="page">
                    <div class="title">Contact Info:</div>
                    <div class="field">
                        <div class="label">Email Address</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Phone Number</div>
                        <input type="Number" required />
                    </div>
                    <div class="field btns">
                        <button class="prev-1 prev">Previous</button>
                        <button class="next-1 next">Next</button>
                    </div>
                </div>

                <div class="page">
                    <div class="title">Contact Info 2:</div>
                    <div class="field">
                        <div class="label">Email Address</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Phone Number</div>
                        <input type="Number" required />
                    </div>
                    <div class="field btns">
                        <button class="prev-2 prev">Previous</button>
                        <button class="next-2 next">Next</button>
                    </div>
                </div>
                
                <div class="page">
                    <div class="title">Contact Info 3:</div>
                    <div class="field">
                        <div class="label">Email Address</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Phone Number</div>
                        <input type="Number" required />
                    </div>
                    <div class="field btns">
                        <button class="prev-3 prev">Previous</button>
                        <button class="next-3 next">Next</button>
                    </div>
                </div>

                <div class="page">
                    <div class="title">Date of Birth:</div>
                    <div class="field">
                        <div class="label">Date</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Gender</div>
                        <select required>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="field btns">
                        <button class="prev-4 prev">Previous</button>
                        <button class="next-4 next">Next</button>
                    </div>
                </div>

                <div class="page">
                    <div class="title">Login Details:</div>
                    <div class="field">
                        <div class="label">Username</div>
                        <input type="text" required />
                    </div>
                    <div class="field">
                        <div class="label">Password</div>
                        <input type="password" required />
                    </div>
                    <div class="field btns">
                        <button class="prev-5 prev">Previous</button>
                        <button class="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js">
        initMultiStepForm();

        function initMultiStepForm() {
            const progressNumber = document.querySelectorAll(".step").length;
            const slidePage = document.querySelector(".slide-page");
            const submitBtn = document.querySelector(".submit");
            const progressText = document.querySelectorAll(".step p");
            const progressCheck = document.querySelectorAll(".step .check");
            const bullet = document.querySelectorAll(".step .bullet");
            const pages = document.querySelectorAll(".page");
            const nextButtons = document.querySelectorAll(".next");
            const prevButtons = document.querySelectorAll(".prev");
            const stepsNumber = pages.length;

            if (progressNumber !== stepsNumber) {
                console.warn(
                    "Error, number of steps in progress bar do not match number of pages"
                );
            }

            document.documentElement.style.setProperty("--stepNumber", stepsNumber);

            let current = 1;

            for (let i = 0; i < nextButtons.length; i++) {
                nextButtons[i].addEventListener("click", function(event) {
                    event.preventDefault();

                    inputsValid = validateInputs(this);
                    // inputsValid = true;

                    if (inputsValid) {
                        slidePage.style.marginLeft = `-${
                    (100 / stepsNumber) * current
                }%`;
                        bullet[current - 1].classList.add("active");
                        progressCheck[current - 1].classList.add("active");
                        progressText[current - 1].classList.add("active");
                        current += 1;
                    }
                });
            }

            for (let i = 0; i < prevButtons.length; i++) {
                prevButtons[i].addEventListener("click", function(event) {
                    event.preventDefault();
                    slidePage.style.marginLeft = `-${
                (100 / stepsNumber) * (current - 2)
            }%`;
                    bullet[current - 2].classList.remove("active");
                    progressCheck[current - 2].classList.remove("active");
                    progressText[current - 2].classList.remove("active");
                    current -= 1;
                });
            }
            submitBtn.addEventListener("click", function() {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current += 1;
                setTimeout(function() {
                    alert("Your Form Successfully Signed up");
                    location.reload();
                }, 800);
            });

            function validateInputs(ths) {
                let inputsValid = true;

                const inputs =
                    ths.parentElement.parentElement.querySelectorAll("input");
                for (let i = 0; i < inputs.length; i++) {
                    const valid = inputs[i].checkValidity();
                    if (!valid) {
                        inputsValid = false;
                        inputs[i].classList.add("invalid-input");
                    } else {
                        inputs[i].classList.remove("invalid-input");
                    }
                }
                return inputsValid;
            }
        }
    </script>
</body>

</html>