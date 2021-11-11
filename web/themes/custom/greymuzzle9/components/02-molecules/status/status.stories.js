import statusTwig from './status.twig';

/**
 * Storybook Definition.
 */
export default {
  title: 'Molecules/Status',
  argTypes: {
    message: {
      control: { type: 'text' },
      defaultValue: 'This is the message text',
    },
    type: {
      control: {
        type: 'select',
        options: ['status', 'warning', 'error'],
      },
      defaultValue: 'status',
    },
  },
};

export const Status = ({ message, type }) => `
<div class="story">
  ${statusTwig({
    message,
    type,
  })}
</div>
`;
