/**
 * Утилиты для защиты форм от спама и улучшения пользовательского опыта
 */


const formSubmissionState = {
    pendingForms: new Set(),
    
    isLocked(formId) {
        return this.pendingForms.has(formId);
    },
    
    lock(formId) {
        this.pendingForms.add(formId);
    },
    
    unlock(formId) {
        this.pendingForms.delete(formId);
    }
};


function initializeHoneypotFields() {
    const forms = document.querySelectorAll('form[id*="Form"], form[id*="form"]');
    
    forms.forEach(form => {
        
        if (form.querySelector('input[name="website_url"], input[name="confirm_bot"]')) {
            return; 
        }
        
        
        const honeypot1 = document.createElement('input');
        honeypot1.type = 'text';
        honeypot1.name = 'website_url';
        honeypot1.style.display = 'none';
        honeypot1.setAttribute('aria-hidden', 'true');
        honeypot1.setAttribute('autocomplete', 'off');
        honeypot1.setAttribute('tabindex', '-1');
        
        const honeypot2 = document.createElement('input');
        honeypot2.type = 'checkbox';
        honeypot2.name = 'confirm_bot';
        honeypot2.style.display = 'none';
        honeypot2.setAttribute('aria-hidden', 'true');
        honeypot2.setAttribute('tabindex', '-1');
        
        
        const csrfToken = form.querySelector('input[name="_token"]');
        if (csrfToken) {
            csrfToken.parentNode.insertBefore(honeypot1, csrfToken.nextSibling);
            csrfToken.parentNode.insertBefore(honeypot2, csrfToken.nextSibling);
        } else {
            form.insertBefore(honeypot1, form.firstChild);
            form.insertBefore(honeypot2, form.firstChild);
        }
    });
}


function validateFormBeforeSubmit(event, formId) {
    const form = event.target;
    
   
    const websiteUrl = form.querySelector('input[name="website_url"]');
    const confirmBot = form.querySelector('input[name="confirm_bot"]');
    
    if ((websiteUrl && websiteUrl.value) || (confirmBot && confirmBot.checked)) {
        console.warn('[Form Protection] Honeypot detected - preventing submission');
        event.preventDefault();
        return false;
    }
    
    
    if (formSubmissionState.isLocked(formId)) {
        event.preventDefault();
        return false;
    }
    
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value || (field.type === 'checkbox' && !field.checked)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        event.preventDefault();
        return false;
    }
    
    
    formSubmissionState.lock(formId);
    
    return true;
}


function unlockForm(formId) {
    formSubmissionState.unlock(formId);
}


function displayFormErrors(errorContainer, errorList, errors) {
    if (!errorContainer || !errorList) {
        return;
    }
    
    errorList.innerHTML = '';
    
    if (typeof errors === 'string') {
        const li = document.createElement('li');
        li.textContent = errors;
        errorList.appendChild(li);
    } else if (typeof errors === 'object') {
        Object.values(errors).forEach(errorArray => {
            if (Array.isArray(errorArray)) {
                errorArray.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
            }
        });
    }
    
    errorContainer.classList.remove('hidden');
    
    
    if (window.innerWidth < 768) {
        setTimeout(() => {
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
}


function getBrowserInfo() {
    const userAgent = navigator.userAgent;
    let browser = 'Неизвестный браузер';
    let os = 'Неизвестная ОС';
    
    
    if (/Chrome/.test(userAgent) && !/Edge|Chromium/.test(userAgent)) {
        browser = 'Chrome';
    } else if (/Firefox/.test(userAgent)) {
        browser = 'Firefox';
    } else if (/Safari/.test(userAgent) && !/Chrome/.test(userAgent)) {
        browser = 'Safari';
    } else if (/Edge/.test(userAgent)) {
        browser = 'Edge';
    } else if (/Opera|OPR/.test(userAgent)) {
        browser = 'Opera';
    }
    
    
    if (/Windows/.test(userAgent)) {
        os = 'Windows';
    } else if (/Mac/.test(userAgent)) {
        os = 'macOS';
    } else if (/Linux/.test(userAgent) && !/Android/.test(userAgent)) {
        os = 'Linux';
    } else if (/Android/.test(userAgent)) {
        os = 'Android';
    } else if (/iPhone|iPad|iPod/.test(userAgent)) {
        os = 'iOS';
    }
    
    return { browser, os, userAgent };
}


document.addEventListener('DOMContentLoaded', function() {
    initializeHoneypotFields();
    
    
    const honeypots = document.querySelectorAll('input[name="website_url"], input[name="confirm_bot"]');
    honeypots.forEach(field => {
        field.addEventListener('autofill', (e) => {
            if (e.target.name === 'website_url' || e.target.name === 'confirm_bot') {
                e.preventDefault();
                e.target.value = '';
            }
        });
    });
});


if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeHoneypotFields,
        validateFormBeforeSubmit,
        unlockForm,
        displayFormErrors,
        getBrowserInfo,
        formSubmissionState
    };
}
