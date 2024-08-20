function addCoverAttribute(settings, name) {
    if (typeof settings.attributes !== 'undefined') {
        if (name == 'core/cover') {
            settings.attributes = Object.assign(settings.attributes, {
                hideOnMobile: {
                    type: 'boolean',
                }
            });
        }
    }
    return settings;
}

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'awp/cover-custom-attribute',
    addCoverAttribute
);

const coverAdvancedControls = wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { Fragment } = wp.element;
        const { ToggleControl } = wp.components;
        const { InspectorAdvancedControls } = wp.blockEditor;
        const { attributes, setAttributes, isSelected } = props;
        if (isSelected && (props.name === 'core/cover')) {
            return wp.element.createElement(
                Fragment,
                null,
                wp.element.createElement(BlockEdit, props),
                wp.element.createElement(
                    InspectorAdvancedControls,
                    null,
                    wp.element.createElement(
                        ToggleControl,
                        {
                            label: wp.i18n.__('Hide on mobile', 'awp'),
                            checked: !!attributes.hideOnMobile,
                            onChange: (_newval) => setAttributes({ hideOnMobile: !attributes.hideOnMobile }),
                        }
                    )
                )
            );
        }
        return wp.element.createElement(
            Fragment,
            null,
            wp.element.createElement(BlockEdit, props),
        );
    };
}, 'coverAdvancedControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'awp/cover-advanced-control',
    coverAdvancedControls
);

function coverApplyExtraClass(extraProps, _blockType, attributes) {
    const { hideOnMobile } = attributes;

    if (typeof hideOnMobile !== 'undefined' && hideOnMobile) {
        extraProps.className = extraProps.className + ' hide-on-mobile';
    }
    return extraProps;
}

wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'awp/cover-apply-class',
    coverApplyExtraClass
);