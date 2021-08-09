// Buttons Stories
import button from './button.twig';

import buttonData from './button.yml';
import buttonAltData from './button-alt.yml';
import buttonDonateDate from './button-donate.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/Button' };

export const defaultButton = () => button(buttonData);

export const altButton = () => button(buttonAltData);

export const donateButton = () => button(buttonDonateDate);
