// Buttons Stories
import ButtonTwig from './button.twig';
/**
 * Storybook Definition.
 */
export default {
  title: 'Atoms/Button',
  argTypes: {
    buttonClass: {
      control: {
        type: 'select',
        options: ['primary', 'alt', 'donate'],
      },
      defaultValue: '',
    },
    buttonText: {
      name: 'Text',
      defaultValue: 'Button',
      control: { type: 'text' },
    },
  },
};

export const Button = ({ buttonText, buttonClass }) =>
  ButtonTwig({
    button_modifiers: [buttonClass],
    button_content: buttonText,
  });
