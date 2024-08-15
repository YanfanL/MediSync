<!DOCTYPE html>
<html>
<?php include 'header.php'; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .container {
        width: 80%;
        margin: auto;
        background: white;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
        border-radius: 8px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .tabs {
        display: flex;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .tab {
        flex: 1;
        padding: 10px;
        text-align: center;
        background: #eee;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        font-weight: bold;
    }
    .tab.active {
        background: #5cb85c;
        color: white;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin: 10px 0 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="file"] {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    .sign_up_btn {
        padding: 10px;
        background: #5cb85c;
        border: 0;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    .sign_up_btn:hover {
        background: #4cae4c;
    }
    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.getAttribute('data-target');
                tabContents.forEach(tc => {
                    if (tc.getAttribute('id') === target) {
                        tc.classList.add('active');
                    } else {
                        tc.classList.remove('active');
                    }
                });
            });
        });

        // Activate the "Upload Lab Results" tab by default
        tabs[0].classList.add('active');
        tabContents[0].classList.add('active');
    });
</script>

<div class="container">
    <div class="tabs">
        <div class="tab active" data-target="upload">Upload Lab Results/Add Notes</div>
    </div>

    <div class="tab-content active" id="upload">
        <form action="lab_results.php" method="post" enctype="multipart/form-data">
            <label for="cardnumber"><b>Health Card Number</b></label>
            <input type="text" placeholder="Enter Health card number" name="cardnumber" required>

            <label for="pdf_file"><b>Choose File</b></label>
            <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required>

            <button name="results" class="sign_up_btn" type="submit">Upload Results</button>
        </form>
    </div>
</div>

<footer><?php include 'footer.php'; ?></footer>
</html>
