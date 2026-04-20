(function () {
  'use strict';

  var form = document.getElementById('strategic-diagnostic-form');
  if (!form) return;

  var steps = Array.prototype.slice.call(form.querySelectorAll('.survey-wizard__step'));
  var prevButton = document.getElementById('survey-prev');
  var nextButton = document.getElementById('survey-next');
  var submitButton = document.getElementById('survey-submit');
  var errorBox = document.getElementById('survey-step-error');
  var feedback = document.getElementById('survey-form-feedback');
  var progressBar = document.getElementById('survey-progress-bar');
  var stepLabel = document.getElementById('survey-step-label');
  var stepPercent = document.getElementById('survey-step-percent');
  var stepTopic = document.getElementById('survey-step-topic');
  var motivationRange = document.getElementById('motivation_score');
  var motivationOutput = document.getElementById('motivation_score_output');

  var currentStep = 0;
  var totalSteps = steps.length;

  function updateMotivationDisplay() {
    if (!motivationRange || !motivationOutput) return;
    motivationOutput.textContent = motivationRange.value + '/10';
  }

  function showError(message) {
    if (!errorBox) return;
    errorBox.textContent = message || '';
    errorBox.style.display = message ? 'block' : 'none';
  }

  function updateProgress() {
    var stepIndex = currentStep + 1;
    var percent = Math.round((stepIndex / totalSteps) * 100);

    steps.forEach(function (step, index) {
      step.classList.toggle('is-active', index === currentStep);
    });

    if (progressBar) {
      progressBar.style.width = percent + '%';
    }

    if (stepLabel) {
      stepLabel.textContent = 'Étape ' + stepIndex + ' sur ' + totalSteps;
    }

    if (stepPercent) {
      stepPercent.textContent = percent + '%';
    }

    if (stepTopic) {
      var title = steps[currentStep] ? steps[currentStep].dataset.stepTitle || '' : '';
      stepTopic.textContent = title ? 'Section en cours : ' + title : '';
    }

    if (prevButton) {
      prevButton.style.visibility = currentStep === 0 ? 'hidden' : 'visible';
    }

    if (nextButton && submitButton) {
      var isLastStep = currentStep === totalSteps - 1;
      nextButton.style.display = isLastStep ? 'none' : 'inline-flex';
      submitButton.style.display = isLastStep ? 'inline-flex' : 'none';
    }

    showError('');
  }

  function getFieldLabel(field, step) {
    if (!field) return 'ce champ';

    if (field.id) {
      var label = step.querySelector('label[for="' + field.id + '"]');
      if (label && label.textContent) return label.textContent.trim();
    }

    if ((field.type === 'radio' || field.type === 'checkbox') && field.name) {
      var first = step.querySelector('[name="' + field.name + '"]');
      if (first && first.closest('.survey-field')) {
        var title = first.closest('.survey-field').querySelector('.survey-field__label');
        if (title && title.textContent) return title.textContent.trim();
      }
    }

    return 'ce champ';
  }

  function validateCurrentStep() {
    var step = steps[currentStep];
    var requiredFields = step.querySelectorAll('[required]');
    var invalid = null;

    for (var i = 0; i < requiredFields.length; i += 1) {
      var field = requiredFields[i];

      if ((field.type === 'radio' || field.type === 'checkbox') && field.name) {
        var group = step.querySelectorAll('[name="' + field.name + '"]');
        var isChecked = Array.prototype.some.call(group, function (item) { return item.checked; });
        if (!isChecked) {
          invalid = field;
          break;
        }
      } else if (!field.value || !String(field.value).trim()) {
        invalid = field;
        break;
      } else if (field.type === 'email' && !field.checkValidity()) {
        invalid = field;
        break;
      }
    }

    if (invalid) {
      var label = getFieldLabel(invalid, step);
      showError('Complète ce point avant de continuer : ' + label + '.');
      if (typeof invalid.focus === 'function') {
        invalid.focus();
      }
      return false;
    }

    showError('');
    return true;
  }

  function collectData() {
    var data = {};
    var formData = new FormData(form);

    formData.forEach(function (value, key) {
      data[key] = typeof value === 'string' ? value.trim() : value;
    });

    var surveyAnswers = {
      experience: {
        experience_years: data.experience_years,
        network_status: data.network_status,
        mandates_per_month: data.mandates_per_month,
        sales_per_year: data.sales_per_year,
        clients_source: data.clients_source,
        digital_tools: data.digital_tools
      },
      probleme: {
        blocker_mandates: data.blocker_mandates,
        current_difficulty: data.current_difficulty,
        prospect_type_difficulty: data.prospect_type_difficulty,
        high_competition: data.high_competition,
        main_frustration: data.main_frustration,
        marketing_tests: data.marketing_tests
      },
      projection: {
        target_mandates_month: data.target_mandates_month,
        target_sales_year: data.target_sales_year,
        target_income: data.target_income,
        ideal_activity: data.ideal_activity,
        acquisition_preference: data.acquisition_preference,
        expected_results_3_6: data.expected_results_3_6
      },
      empechement: {
        current_obstacle: data.current_obstacle,
        main_obstacle_type: data.main_obstacle_type,
        investment_brake: data.investment_brake,
        already_tried_changes: data.already_tried_changes,
        need_to_progress: data.need_to_progress,
        primary_brake: data.primary_brake
      },
      qualification: {
        ready_to_invest: data.ready_to_invest,
        desired_timeline: data.desired_timeline,
        motivation_score: data.motivation_score,
        open_to_change: data.open_to_change
      }
    };

    return {
      nom: data.nom || '',
      email: data.email,
      city: data.city || '',
      phone: data.phone || '',
      source: data.source || 'sondage_conseillers_2026',
      survey_answers: surveyAnswers
    };
  }

  function setSubmitting(isSubmitting) {
    if (!submitButton) return;
    submitButton.disabled = isSubmitting;
    submitButton.textContent = isSubmitting ? 'Envoi en cours…' : 'Recevoir ma synthèse';
  }

  if (nextButton) {
    nextButton.addEventListener('click', function () {
      if (!validateCurrentStep()) return;
      if (currentStep < totalSteps - 1) {
        currentStep += 1;
        updateProgress();
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  }

  if (prevButton) {
    prevButton.addEventListener('click', function () {
      if (currentStep > 0) {
        currentStep -= 1;
        updateProgress();
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  }

  if (motivationRange) {
    motivationRange.addEventListener('input', updateMotivationDisplay);
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    if (!validateCurrentStep()) return;

    var payload = collectData();
    setSubmitting(true);
    showError('');

    if (feedback) {
      feedback.textContent = '';
      feedback.className = 'survey-form__feedback';
    }

    fetch('/api/sondage-strategique.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
      .then(function (response) { return response.json(); })
      .then(function (result) {
        if (!result || !result.ok) {
          throw new Error('submit_failed');
        }

        if (result.result_url) {
          window.location.href = result.result_url;
          return;
        }

        if (feedback) {
          feedback.textContent = 'Merci. Ta synthèse est en préparation et arrive par email.';
          feedback.className = 'survey-form__feedback survey-form__feedback--success';
        }

        form.reset();
        currentStep = 0;
        updateMotivationDisplay();
        updateProgress();
      })
      .catch(function () {
        if (feedback) {
          feedback.textContent = 'Impossible d’envoyer pour le moment. Merci de réessayer dans quelques instants.';
          feedback.className = 'survey-form__feedback survey-form__feedback--error';
        }
      })
      .finally(function () {
        setSubmitting(false);
      });
  });

  updateMotivationDisplay();
  updateProgress();
})();
