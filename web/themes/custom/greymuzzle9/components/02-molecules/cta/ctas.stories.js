import ctaTwig from './cta.twig';
import ctaData from './cta.yml';

export default {
  title: 'Molecules/CTA',
  argTypes: {
    Heading: {
      control: { type: 'text' },
      defaultValue: ctaData.cta__heading,
    },
  },
};

export const CTA = ({ Heading }) => `
  <div class="story">
    ${ctaTwig({
      ...ctaData,
      cta__heading: Heading,
    })}
  </div>
`;
