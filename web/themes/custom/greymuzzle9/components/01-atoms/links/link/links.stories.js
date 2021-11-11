import linkTwig from './link.twig';
import linkData from './link.yml';

/**
 * Storybook Definition.
 */
export default {
  title: 'Atoms/Links',
  description: 'Links with variations',
  argTypes: {
    LinkText: {
      name: 'link_content',
      type: String,
      description: 'Text of the link or button.',
      control: { type: 'text' },
      defaultValue: linkData.link_content,
    },
    LinkType: {
      name: 'link_modifiers',
      type: String,
      control: {
        type: 'check',
        options: {
          'Button Style': 'button',
          'Button Alternative Color': 'button--alt',
          'Donate Button': 'button--donate',
          'large button (use with above button modifiers)': 'button--large',
        },
        mapping: {
          link: null,
        },
      },
      description: 'Controls the type of link',
      defaultValue: 'link',
    },
    LinkHiddenMessage: {
      name: 'link_hidden_message',
      description: 'Modifiers to make links look like buttons',
      type: Array,
      control: { type: 'text' },
      defaultValue: '',
    },
  },
};

export const links = ({ LinkText, LinkType, LinkHiddenMessage }) => `
  <div>
    ${linkTwig({
      ...linkData,
      link_content: LinkText,
      link_modifiers: LinkType,
      link_hidden_message: LinkHiddenMessage,
    })}
  </div>
`;
