<!-----message----->
<style>
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        border-radius: 8px;
        margin: 1rem auto;
        max-width: 500px;
        font-family: 'Segoe UI', sans-serif;
        font-size: 16px;
        position: relative;
        animation: fadeIn 0.4s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .alert-success {
        background-color: #e0f7ef;
        color: #2e7d32;
    }

    .alert-error {
        background-color: #fdecea;
        color: #c62828;
    }

    .alert .icon {
        font-size: 20px;
    }

    .alert .close-btn {
        position: absolute;
        right: 15px;
        top: 12px;
        background: none;
        border: none;
        font-size: 18px;
        color: inherit;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .alert .close-btn:hover {
        opacity: 0.8;
    }

    .alert.hide {
        opacity: 0;
        transform: translateY(-10px);
        pointer-events: none;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="fi fi-sr-check-circle icon"></i>
    <span>
        <?= htmlspecialchars($success) ?>
    </span>
    <button class="close-btn" onclick="this.parentElement.classList.add('hide')">&times;</button>
</div>
<?php endif; ?>

<?php if (!empty($error)): ?>
<div class="alert alert-error">
    <i class="fi fi-sr-cross-circle icon"></i>
    <span>
        <?= htmlspecialchars($error) ?>
    </span>
    <button class="close-btn" onclick="this.parentElement.classList.add('hide')">&times;</button>
</div>
<?php endif; ?>