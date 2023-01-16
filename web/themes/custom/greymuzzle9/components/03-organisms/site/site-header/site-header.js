/**
 * Toggles a class of dyslexia on the body element when the
 * Dyslexia button is clicked so that fonts can be changed.
 */
Drupal.behaviors.greymuzzleDyslexia = {
  attach() {
    let dyslexic = false;
    const { cookies } = window;
    // console.log(document.cookie);
    // Set aria-checked on first page load.
    const dyslexia = document.getElementById('dyslexia');
    const dattr = dyslexia.getAttribute('aria-checked');
    if (dattr === undefined) {
      if (cookies.get('dyslexia').value === true) {
        dyslexia.setAttribute('aria-checked', true);
      } else {
        dyslexia.setAttribute('aria-checked', false);
      }
    }

    const dyslexiaSet = () => {
      document.querySelector('body').classList.toggle('dyslexia');
      const d = document.getElementById('dyslexia');
      d.classList.toggle('active');
      d.setAttribute('aria-checked', !d.getAttribute('aria-checked'));
      if (dyslexic === false) {
        cookies.set({
          name: 'dyslexia',
          value: true,
          path: '/',
          domain: window.location.host,
          expires: 1000,
        });
        dyslexic = true;
      } else {
        cookies.set({
          name: 'dyslexia',
          value: false,
          path: '/',
          domain: window.location.host,
        });
        dyslexic = false;
      }
    }

    document.getElementById('dyslexia').addEventListener('click', () => {
      // console.log(document.querySelector('body'));
      // if (document.querySelector('body').classList.contains('dyslexia')) {
      // dyslexic = true;
      // }
      dyslexiaSet();
    });
  },
};

/**
 * Toggles a class of contrast on the body element when the
 * Contrast button is clicked so that fonts can be changed.
 */
Drupal.behaviors.greymuzzleContrast = {
  attach() {
    let contrasted = false;
    const { cookies } = window;

    // Set aria-checked on first page load.
    const contrast = document.getElementById('#contrast');
    const cAttribute = contrast.getAttribute('aria-checked');
    if (cAttribute === undefined) {
      if (cookies.get('contrast').value === true) {
        contrast.setAttribute('aria-checked', true);
      } else {
        contrast.setAttribute('aria-checked', false);
      }
    }

    const contrastSet = () => {
      document.querySelector('body').classList.toggle('contrast');
      contrast.classList.toggle('active');
      contrast.setAttribute(
        'aria-checked',
        !contrast.getAttribute('aria-checked'),
      );
      if (contrasted === false) {
        cookies.set({
          name: 'contrast',
          value: true,
          path: '/',
          domain: window.location.host,
          expires: 1000,
        });
        contrasted = true;
      } else {
        cookies.set({
          name: 'contrast',
          value: null,
          path: '/',
          domain: window.location.host,
        });
        contrasted = false;
      }
    }

    contrast.addEventListener('click', () => {
      // if (document.querySelector('body').classList.contains('contrast')) {
      //   contrasted = true;
      // }
      contrastSet();
    });
  },
};

// Add state to text resize links.
// Add support for spacebar to activate resize links.
Drupal.behaviors.greymuzzleResizeText = {
  attach() {
    // Set aria-checked on first page load.
    document
      .querySelectorAll(".text-resize a[role='radio']")
      .forEach((item) => {
        const attr = item.getAttribute('aria-checked');
        if (attr === undefined) {
          item.setAttribute('aria-checked', 'false');
        }
      });

    const toggleChecked = (t) => {
      t.setAttribute('aria-checked', !t.getAttribute('aria-checked'));
    };

    const setRadio = (t) => {
      const currentlyChecked = t.parentElement.querySelectorAll(
        "a[aria-checked='true']",
      )[0];
      if (t.getAttribute('aria-checked') === true) {
        return;
      }
      toggleChecked(t);
      toggleChecked(currentlyChecked);
    };

    // Support spacebar press to activate text resize.
    const handleKeyEnter = (t, key, handler, e) => {
      if (key === 32) {
        handler(t);
        t.click();
        e.preventDefault();
      }
    };

    document
      .querySelectorAll(".text-resize a[role='radio']")
      .addEventListener('keydown', (event) => {
        const t = event.currentTarget;
        handleKeyEnter(t, event.which, setRadio, event);
      })
      .addEventListener('click', (event) => {
        const t = event.currentTarget;
        setRadio(t);
      });
  },
};
