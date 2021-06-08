/**
 * CAGov Card Grid
 *
 */
(function (blocks, element, blockEditor) {
  const el = element.createElement;
  const InnerBlocks = blockEditor.InnerBlocks;
  const ALLOWED_BLOCKS = ['ca-design-system/card'];
  blocks.registerBlockType('ca-design-system/card-grid', {
    title: 'Card grid',
    category: 'ca-design-system',
    edit: function (props) {
      return el(
        'div',
        { className: 'cagov-grid' },
        el(InnerBlocks,
          {
            orientation: 'horizontal',
            allowedBlocks: ALLOWED_BLOCKS
          }
        )
      );
    },
    save: function (props) {
      return el(
        'div',
        { className: 'cagov-grid' },
        el(InnerBlocks.Content)
      );
    }
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
