module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    container: {
      center: true,
    },
    colors: {
      white: '#fff',
      black: '#000',
      gray: {
        tundora: '#444',
        gallery: '#ccc',
        light: '#eee'
      },
      blue: {
        chill: '#067799',
        botticelli: '#cfe5eb',
        alice: '#f3f8fa'
      },
      sienna: '#f06667',
      sunglow: '#ffcc33',
      daffodil: '#fff5d6',
      yellow: '#ffff00'
    },
    fontFamily: {
      sans: ['Montserrat', 'Arial', 'sans-serif'],
      serif: ['Montserrat', 'Arial', 'sans-serif'],
      dyslexic: ['opendyslexic', 'sans-serif'],
      fa: ['FontAwesome', 'sans-serif']
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    function ({ addComponents }) {
      addComponents({
        '.container': {
          maxWidth: '100%',
          '@screen sm': {
            maxWidth: '640px',
          },
          '@screen md': {
            maxWidth: '768px',
          },
          '@screen lg': {
            maxWidth: '1055px',
          },
          '@screen xl': {
            maxWidth: '1055px',
          },
        }
      })
    }
  ]
}
