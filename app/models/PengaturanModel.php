<?php
class PengaturanModel extends BaseModel {
    protected $table = 'tbl_pengaturan';
    protected $fillable = ['judul_app', 'deskripsi', 'logo', 'favicon'];
    
    public function getSettings() {
        $settings = $this->findOne();
        
        if (!$settings) {
            // Create default settings if none exist
            $id = $this->create([
                'judul_app' => 'NUSANTARA HMVC',
                'deskripsi' => 'Medical Record System'
            ]);
            $settings = $this->find($id);
        }
        
        return $settings;
    }
    
    public function updateSettings($data) {
        try {
            // Log incoming data
            error_log("Updating settings with data: " . json_encode($data));
            
            $settings = $this->findOne();
            if (!$settings) {
                error_log("No settings found, creating new...");
                return $this->create($data);
            }
            
            error_log("Found existing settings with ID: " . $settings->id);
            
            // Keep existing files if not uploading new ones
            if (!isset($data['logo']) || empty($data['logo'])) {
                unset($data['logo']);
            }
            if (!isset($data['favicon']) || empty($data['favicon'])) {
                unset($data['favicon']);
            }
            
            // Log filtered data
            error_log("Filtered update data: " . json_encode($data));
            
            $result = $this->update($settings->id, $data);
            
            if ($result) {
                error_log("Settings updated successfully");
                return true;
            } else {
                throw new Exception("Update returned false");
            }
            
        } catch (Exception $e) {
            error_log("Failed to update settings: " . $e->getMessage());
            throw $e;
        }
    }
} 