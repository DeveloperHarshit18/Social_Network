// Authentication JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Auth script loaded');
    
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const messageDiv = document.getElementById('message');
    
    // Simple profile picture upload
    const fileInput = document.getElementById('profile_picture');
    const uploadBtn = document.getElementById('upload-profile-btn');
    const placeholder = document.getElementById('profile-picture-placeholder');
    const preview = document.getElementById('profile-picture-preview');
    const removeBtn = document.getElementById('remove-profile-btn');
    
    console.log('File input found:', !!fileInput);
    console.log('Upload button found:', !!uploadBtn);
    
    // Upload button click
    if (uploadBtn) {
        uploadBtn.onclick = function(e) {
            e.preventDefault();
            console.log('Button clicked');
            if (fileInput) {
                fileInput.click();
            }
        };
    }
    
    // Placeholder click
    if (placeholder) {
        placeholder.onclick = function(e) {
            e.preventDefault();
            console.log('Placeholder clicked');
            if (fileInput) {
                fileInput.click();
            }
        };
    }
    
    // File selection
    if (fileInput) {
        fileInput.onchange = function(e) {
            console.log('File changed');
            const file = e.target.files[0];
            if (file) {
                console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, or GIF)');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file size (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB');
                    fileInput.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('Reader loaded');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }
                        if (removeBtn) {
                            removeBtn.style.display = 'block';
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        };
    }
    
    // Remove button
    if (removeBtn) {
        removeBtn.onclick = function() {
            if (fileInput) fileInput.value = '';
            if (preview) preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
            if (removeBtn) removeBtn.style.display = 'none';
        };
    }

    // Show message function
    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.className = `message ${type}`;
        messageDiv.style.display = 'block';
        
        // Hide message after 5 seconds
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 5000);
    }

    // Handle login form submission
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(loginForm);
            
            try {
                const response = await fetch('ajax/login_process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            }
        });
    }

    // Handle signup form submission
    if (signupForm) {
        signupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = signupForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Creating Account...';
            submitBtn.disabled = true;
            
            const formData = new FormData(signupForm);
            
            // Debug: Log form data
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            try {
                const response = await fetch('ajax/signup_process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            } finally {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
