import motion from './motion.twig';

import motionData from './motion.yml';

/**
 * Add storybook definition for Animations.
 */
export default { title: 'Base/Motion Usage' };

export const MotionUsage = () => motion(motionData);
