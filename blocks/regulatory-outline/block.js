/**
 * CAGov Step list
 */
(function (blocks, i18n) {
  var __ = i18n.__;
  blocks.registerBlockVariation(
    'core/list',
    [
      {
        name: 'regulatory-outline',
        title: 'Regulatory outline',
        attributes: {
          className: 'regulatory-outline'
        },
        icon: "format-aside",
        category: 'ca-design-system',
        description: "List styling for a regulatory outline", 
    }
    ]
  );
})(
  window.wp.blocks,
  window.wp.i18n,
);
