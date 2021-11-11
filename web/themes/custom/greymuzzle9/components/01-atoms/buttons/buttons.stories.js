// Buttons Stories
import buttonTwig from './button.twig';

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
      control: {
        type: 'text',
      },
      defaultValue: 'Button Text',
    },
  },
  parameters: {
    actions: {
      handles: ['mouseover', 'click .button'],
    },
  },
};

export const button = ({ buttonClass, buttonText }) => `
  <div class="button-story">
    ${buttonTwig({
      button_modifiers: [buttonClass],
      button_content: buttonText,
      button_url: '#',
    })}
  </div>
`;
