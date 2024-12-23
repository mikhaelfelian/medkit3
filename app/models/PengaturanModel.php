<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturan';
    
    public function getSettings() {
        $settings = $this->findOne();
        
        if ($settings) {
            // Convert relative paths to asset URLs
            if (!empty($settings->logo)) {
                $settings->logo = 'images/' . $settings->logo;
            }
            if (!empty($settings->favicon)) {
                $settings->favicon = 'images/' . $settings->favicon;
            }
        }
        
        return $settings;
    }
} 